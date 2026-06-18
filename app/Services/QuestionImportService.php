<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Answer;
use App\Models\QuestionTopic;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use Exception;

class QuestionImportService
{
    private const IMG_PLACEHOLDER = '[[IMG]]';

    private function normalizeExplanation(?string $text): ?string
    {
        $text = trim((string) $text);
        if ($text === '') {
            return null;
        }

        if (preg_match('/<[a-z][\s\S]*>/i', $text)) {
            return $text;
        }

        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $lines = array_filter(array_map('trim', explode("\n", $text)), fn ($l) => $l !== '');

        if (empty($lines)) {
            return null;
        }

        return collect($lines)
            ->map(fn ($line) => '<p>' . e($line) . '</p>')
            ->implode('');
    }

    private function normalizeAnswer(string $text): string
    {
        $text = trim($text);

        if (preg_match('/^<(div|p)\b[^>]*>(.*)<\/\1>$/is', $text, $m)
            && stripos($m[2], '<div') === false
            && stripos($m[2], '<p') === false
        ) {
            return trim($m[2]);
        }

        return $text;
    }

    private function imgTag(string $finalPath, string $fileName): string
    {
        $url = "/storage/{$finalPath}/{$fileName}";
        return '<p><img src="' . $url . '"><br></p>';
    }

    private function injectImage(string $content, string $finalPath, string $fileName): string
    {
        if (str_contains($content, self::IMG_PLACEHOLDER)) {
            $url     = "/storage/{$finalPath}/{$fileName}";
            $bareImg = '<img src="' . $url . '" alt="">';
            return preg_replace('/\[\[IMG\]\]/', $bareImg, $content, 1);
        }

        return $content . $this->imgTag($finalPath, $fileName);
    }

    private function stripLeftoverPlaceholders(string $content): string
    {
        return str_replace(self::IMG_PLACEHOLDER, '', $content);
    }

    private function findExtractedImage(string $imagesDir, string $base): ?string
    {
        foreach (['png', 'jpg', 'jpeg', 'webp', 'gif'] as $ext) {
            $path = "{$imagesDir}/{$base}.{$ext}";
            if (is_file($path)) {
                return "{$base}.{$ext}";
            }
        }
        return null;
    }

    public function importFromUpload($file, $tryoutId = null)
    {
        $ext  = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        return $this->importFromFile($path, $tryoutId, $ext);
    }

    public function importFromFile(string $filePath, $tryoutId = null, ?string $extHint = null)
    {
        $ext = $extHint ?: strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($ext === '') {
            $ext = $this->detectByMagicBytes($filePath);
        }

        if ($ext === 'zip') {
            return $this->importFromZip($filePath, $tryoutId);
        }

        return $this->process($filePath, null, $tryoutId);
    }

    public function analyze($file, $tryoutId = null): array
    {
        $ext = strtolower($file->getClientOriginalExtension());

        $tmpDir = storage_path('app/tmp');
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $this->cleanupOldTmp($tmpDir);

        $token      = bin2hex(random_bytes(16));
        $storedPath = "{$tmpDir}/review_{$token}.{$ext}";
        copy($file->getRealPath(), $storedPath);

        [$xlsxPath, $imagesDir, $cleanupDir] = $this->resolveSources($storedPath, $ext);

        try {
            $rows = $this->collectValidation($xlsxPath, $imagesDir);
        } finally {
            if ($cleanupDir) {
                $this->rrmdir($cleanupDir);
            }
        }

        $ok     = collect($rows)->where('status', 'ok')->count();
        $failed = collect($rows)->where('status', 'failed')->count();

        return [
            'token'   => $token,
            'ext'     => $ext,
            'summary' => [
                'total'  => count($rows),
                'ok'     => $ok,
                'failed' => $failed,
            ],
            'rows' => $rows,
        ];
    }

    public function commitFromToken(string $token, string $ext, $tryoutId = null): array
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $token)) {
            throw new Exception('Token import tidak valid.');
        }
        $ext = strtolower($ext);
        if (!in_array($ext, ['zip', 'xlsx', 'xls'], true)) {
            throw new Exception('Tipe file import tidak valid.');
        }

        $storedPath = storage_path("app/tmp/review_{$token}.{$ext}");
        if (!is_file($storedPath)) {
            throw new Exception('File import sudah tidak tersedia. Silakan ulangi upload.');
        }

        try {
            $result = $this->importFromFile($storedPath, $tryoutId, $ext);
        } finally {
            @unlink($storedPath);
        }

        return $result;
    }

    private function resolveSources(string $storedPath, string $ext): array
    {
        if ($ext === '') {
            $ext = $this->detectByMagicBytes($storedPath);
        }

        if ($ext === 'zip') {
            $extractDir = storage_path('app/tmp/review_extract_' . uniqid());
            if (!is_dir($extractDir)) {
                mkdir($extractDir, 0755, true);
            }

            $zip = new \ZipArchive();
            if ($zip->open($storedPath) !== true) {
                $this->rrmdir($extractDir);
                throw new Exception('Gagal membuka file ZIP.');
            }
            $zip->extractTo($extractDir);
            $zip->close();

            $xlsxPath = $this->locateXlsx($extractDir);
            if (!$xlsxPath) {
                $this->rrmdir($extractDir);
                throw new Exception('File soal.xlsx tidak ditemukan di dalam ZIP.');
            }

            $imagesDir = dirname($xlsxPath) . '/images';
            return [$xlsxPath, is_dir($imagesDir) ? $imagesDir : null, $extractDir];
        }

        return [$storedPath, null, null];
    }

    private function collectValidation(string $xlsxPath, ?string $imagesDir): array
    {
        $spreadsheet = IOFactory::load($xlsxPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows  = $sheet->toArray(null, true, true, true);

        $out = [];

        foreach ($rows as $index => $row) {
            if ($index === 1) continue;

            $nomor    = (int) trim($row['A'] ?? 0);
            $kategori = trim($row['B'] ?? '');
            $topik    = trim($row['C'] ?? '');
            $soal     = trim($row['D'] ?? '');

            if ($kategori === '' && $topik === '' && $soal === '') {
                continue;
            }

            $error = $this->validateRow($row, $imagesDir);

            $out[] = [
                'row'    => $index,
                'number' => $nomor,
                'status' => $error === null ? 'ok' : 'failed',
                'label'  => trim("{$kategori} - {$topik}", ' -'),
                'reason' => $error,
            ];
        }

        return $out;
    }

    private function validateRow(array $row, ?string $imagesDir): ?string
    {
        $nomor    = (int) trim($row['A'] ?? 0);
        $kategori = trim($row['B'] ?? '');
        $topik    = trim($row['C'] ?? '');

        $jawaban = [
            trim($row['E'] ?? ''),
            trim($row['F'] ?? ''),
            trim($row['G'] ?? ''),
            trim($row['H'] ?? ''),
            trim($row['I'] ?? ''),
        ];

        $scores = [
            (int)($row['L'] ?? 0),
            (int)($row['M'] ?? 0),
            (int)($row['N'] ?? 0),
            (int)($row['O'] ?? 0),
            (int)($row['P'] ?? 0),
        ];

        $topic = QuestionTopic::where('category', $kategori)
            ->where('name', $topik)
            ->first();

        if (!$topic) {
            return "Topik tidak ditemukan: {$kategori} - {$topik}";
        }

        $soal       = trim($row['D'] ?? '');
        $hasSoalImg = $imagesDir
            && $this->findExtractedImage($imagesDir, "question-{$nomor}") !== null;

        if ($soal === '' && !$hasSoalImg) {
            return "Soal kosong (teks & gambar tidak ditemukan).";
        }

        // ── Validasi multi-gambar untuk SOAL & PENJELASAN ──
        // Jumlah token [[IMG]] HARUS sama dgn jumlah file gambar berurutan.
        $multiChecks = [
            ['D', "question-{$nomor}",    'Soal'],
            ['K', "explanation-{$nomor}", 'Penjelasan'],
        ];
        foreach ($multiChecks as [$col, $base, $label]) {
            $val        = (string) ($row[$col] ?? '');
            $tokenCount = substr_count($val, self::IMG_PLACEHOLDER);
            $fileCount  = $imagesDir ? count($this->collectSequentialImages($imagesDir, $base)) : 0;

            if ($tokenCount === 0) {
                continue; // tidak pakai token → append legacy, tidak divalidasi ketat
            }

            if ($fileCount === 0) {
                return "{$label} memakai " . self::IMG_PLACEHOLDER
                    . " tapi file {$base}.* tidak ditemukan di folder images.";
            }

            if ($tokenCount !== $fileCount) {
                return "{$label}: jumlah " . self::IMG_PLACEHOLDER
                    . " ({$tokenCount}) tidak sama dengan jumlah file gambar ({$fileCount}). "
                    . "Pastikan {$base}, {$base}-2, {$base}-3, … sesuai jumlah token.";
            }
        }

        // ── Validasi token jawaban A–E (tetap single) ──
        $answerChecks = [
            ['E', "answer-{$nomor}-A", 'Jawaban A'],
            ['F', "answer-{$nomor}-B", 'Jawaban B'],
            ['G', "answer-{$nomor}-C", 'Jawaban C'],
            ['H', "answer-{$nomor}-D", 'Jawaban D'],
            ['I', "answer-{$nomor}-E", 'Jawaban E'],
        ];
        foreach ($answerChecks as [$col, $base, $label]) {
            $val = (string) ($row[$col] ?? '');
            if (str_contains($val, self::IMG_PLACEHOLDER)) {
                $found = $imagesDir ? $this->findExtractedImage($imagesDir, $base) : null;
                if (!$found) {
                    return "{$label} memakai " . self::IMG_PLACEHOLDER
                        . " tapi file {$base}.* tidak ditemukan di folder images.";
                }
            }
        }

        if ($topic->category === 'TKP') {
            $sorted = $scores;
            sort($sorted);
            if ($sorted !== [1, 2, 3, 4, 5]) {
                return "Skor TKP harus permutasi unik 1–5, dapat: " . implode(',', $scores);
            }
        }

        foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
            $hasText  = $jawaban[$i] !== '';
            $hasImage = $imagesDir
                && $this->findExtractedImage($imagesDir, "answer-{$nomor}-{$opt}") !== null;

            if (!$hasText && !$hasImage) {
                return "Jawaban {$opt} kosong (teks & gambar tidak ditemukan).";
            }
        }

        return null;
    }

    /**
     * Kumpulkan SEMUA file gambar berurutan untuk satu basis nama:
     *   {base}      → gambar ke-1 (tanpa suffix)
     *   {base}-2    → gambar ke-2
     *   {base}-3    → gambar ke-3
     *   … berhenti saat nomor berikutnya tidak ditemukan.
     *
     * Mengembalikan array nama file lengkap, terurut: ['explanation-58.jpg', 'explanation-58-2.jpg', …]
     * Kosong bila gambar pertama ({base}) tidak ada.
     */
    private function collectSequentialImages(string $imagesDir, string $base): array
    {
        $files = [];

        // Gambar pertama: tanpa suffix
        $first = $this->findExtractedImage($imagesDir, $base);
        if (!$first) {
            return []; // tidak ada gambar sama sekali utk slot ini
        }
        $files[] = $first;

        // Lanjut -2, -3, -4, … sampai putus
        $n = 2;
        while (($next = $this->findExtractedImage($imagesDir, "{$base}-{$n}")) !== null) {
            $files[] = $next;
            $n++;
        }

        return $files;
    }

    private function detectByMagicBytes(string $filePath): string
    {
        $fh = @fopen($filePath, 'rb');
        if (!$fh) return '';
        $sig = fread($fh, 4);
        fclose($fh);

        if (str_starts_with($sig, "PK")) {
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $isXlsxItself = $zip->locateName('xl/workbook.xml') !== false;
                $zip->close();
                return $isXlsxItself ? 'xlsx' : 'zip';
            }
        }
        return 'xlsx';
    }

    private function importFromZip(string $zipPath, $tryoutId = null)
    {
        $extractDir = storage_path('app/tmp/import_' . uniqid());
        if (!is_dir($extractDir)) {
            mkdir($extractDir, 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath) !== true) {
            throw new Exception('Gagal membuka file ZIP.');
        }
        $zip->extractTo($extractDir);
        $zip->close();

        $xlsxPath = $this->locateXlsx($extractDir);
        if (!$xlsxPath) {
            $this->rrmdir($extractDir);
            throw new Exception('File soal.xlsx tidak ditemukan di dalam ZIP.');
        }

        $imagesDir = dirname($xlsxPath) . '/images';

        try {
            $result = $this->process($xlsxPath, is_dir($imagesDir) ? $imagesDir : null, $tryoutId);
        } finally {
            $this->rrmdir($extractDir);
        }

        return $result;
    }

    private function process(string $xlsxPath, ?string $imagesDir, $tryoutId = null)
    {
        $spreadsheet = IOFactory::load($xlsxPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows  = $sheet->toArray(null, true, true, true);

        $nextOrder = 0;
        if ($tryoutId) {
            $nextOrder = (int) DB::table('question_tryout')
                ->where('tryout_id', $tryoutId)
                ->max('order');
        }

        $success = 0;
        $log     = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                if ($index === 1) continue;
                $rowNumber = $index;

                $nomor      = (int) trim($row['A'] ?? 0);
                $kategori   = trim($row['B'] ?? '');
                $topik      = trim($row['C'] ?? '');
                $soal       = trim($row['D'] ?? '');
                $penjelasan = $this->normalizeExplanation($row['K'] ?? '');

                $jawaban = [
                    $this->normalizeAnswer(trim($row['E'] ?? '')),
                    $this->normalizeAnswer(trim($row['F'] ?? '')),
                    $this->normalizeAnswer(trim($row['G'] ?? '')),
                    $this->normalizeAnswer(trim($row['H'] ?? '')),
                    $this->normalizeAnswer(trim($row['I'] ?? '')),
                ];

                $jawabanBenar = strtoupper(trim($row['J'] ?? ''));

                $scores = [
                    (int)($row['L'] ?? 0),
                    (int)($row['M'] ?? 0),
                    (int)($row['N'] ?? 0),
                    (int)($row['O'] ?? 0),
                    (int)($row['P'] ?? 0),
                ];

                if ($kategori === '' && $topik === '' && $soal === '') {
                    continue;
                }

                if ($error = $this->validateRow($row, $imagesDir)) {
                    throw new Exception("Baris {$rowNumber}: {$error}");
                }

                $topic = QuestionTopic::where('category', $kategori)
                    ->where('name', $topik)
                    ->first();

                $question = Question::create([
                    'topic_id'    => $topic->id,
                    'question'    => $soal,
                    'explanation' => $penjelasan,
                ]);

                $finalPath = "question/{$question->id}";

                $questionHtml    = $soal;
                $explanationHtml = $penjelasan ?? '';

                if ($imagesDir) {
                    // SOAL — multi-gambar (token [[IMG]] berurutan) atau single/append
                    $questionHtml = $this->injectMultiImages(
                        $questionHtml, $imagesDir, "question-{$nomor}", $finalPath, 'question'
                    );

                    // PENJELASAN — multi-gambar
                    $explanationHtml = $this->injectMultiImages(
                        $explanationHtml, $imagesDir, "explanation-{$nomor}", $finalPath, 'explanation'
                    );

                    // JAWABAN A–E — tetap single
                    foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                        if ($file = $this->moveImage($imagesDir, "answer-{$nomor}-{$opt}", $finalPath, $opt)) {
                            $url = "/storage/{$finalPath}/{$file}";

                            if (str_contains($jawaban[$i], self::IMG_PLACEHOLDER)) {
                                $jawaban[$i] = $this->injectImage($jawaban[$i], $finalPath, $file);
                            } else {
                                $jawaban[$i] = '<img src="' . $url . '">';
                            }
                        }
                    }
                }

                $questionHtml    = $this->stripLeftoverPlaceholders($questionHtml);
                $explanationHtml = $this->stripLeftoverPlaceholders($explanationHtml);
                foreach ($jawaban as $k => $v) {
                    $jawaban[$k] = $this->stripLeftoverPlaceholders($v);
                }

                if ($questionHtml !== $soal || $explanationHtml !== ($penjelasan ?? '')) {
                    $question->update([
                        'question'    => $questionHtml,
                        'explanation' => $explanationHtml,
                    ]);
                }

                foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                    if ($topic->category === 'TKP') {
                        $score = (int) $scores[$i];
                    } else {
                        $score = ($jawabanBenar === $opt) ? 5 : 0;
                    }

                    Answer::create([
                        'question_id' => $question->id,
                        'option'      => $opt,
                        'answer'      => $jawaban[$i],
                        'score'       => $score,
                    ]);
                }

                if ($tryoutId) {
                    $nextOrder++;
                    DB::table('question_tryout')->insert([
                        'tryout_id'   => $tryoutId,
                        'question_id' => $question->id,
                        'order'       => $nextOrder,
                    ]);
                }

                $success++;
                $log[] = "✅ Baris {$rowNumber} [{$kategori} - {$topik}]";
            }

            DB::commit();
            Log::info("✅ Import selesai: {$success} soal tersimpan.");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ Import dibatalkan (rollback): " . $e->getMessage());
            throw $e;
        }

        return [
            'success'  => $success,
            'failed'   => 0,
            'log_file' => $log,
        ];
    }

    /**
     * Sisipkan gambar (bisa lebih dari satu) ke dalam konten.
     *
     * - Konten mengandung [[IMG]]:
     *     Tiap token ke-N diganti gambar ke-N (berurutan dari
     *     collectSequentialImages). Jumlah sudah dipastikan cocok oleh
     *     validateRow, tapi tetap aman bila tidak (token sisa dibuang nanti).
     *
     * - Konten TIDAK mengandung [[IMG]] tapi gambar ada:
     *     Append SEMUA gambar di akhir (legacy), berurutan.
     *
     * - Tidak ada gambar sama sekali: konten dikembalikan apa adanya.
     *
     * Tiap file dipindah ke storage final dgn nama slot unik:
     *   gambar ke-1 → {slot}.{ext}      (mis. explanation.jpg)
     *   gambar ke-2 → {slot}-2.{ext}    (mis. explanation-2.jpg)
     *   …
     */
    private function injectMultiImages(
        string $content,
        string $imagesDir,
        string $base,
        string $finalPath,
        string $slot
    ): string {
        $sources = $this->collectSequentialImages($imagesDir, $base);
        if (empty($sources)) {
            return $content; // tidak ada gambar utk slot ini
        }

        // Pindahkan semua file ke storage final dgn nama slot berurutan.
        // $finalNames[i] = nama file final utk gambar ke-(i+1)
        $finalNames = [];
        foreach ($sources as $i => $srcName) {
            $ext       = pathinfo($srcName, PATHINFO_EXTENSION);
            $finalName = $i === 0 ? "{$slot}.{$ext}" : "{$slot}-" . ($i + 1) . ".{$ext}";

            Storage::disk('public')->makeDirectory($finalPath);
            $contents = file_get_contents("{$imagesDir}/{$srcName}");
            Storage::disk('public')->put("{$finalPath}/{$finalName}", $contents);

            $finalNames[] = $finalName;
        }

        // Ada token → ganti tiap token berurutan dgn gambar ke-N
        if (str_contains($content, self::IMG_PLACEHOLDER)) {
            foreach ($finalNames as $finalName) {
                if (!str_contains($content, self::IMG_PLACEHOLDER)) {
                    break; // token habis (jumlah dijaga validateRow)
                }
                $url     = "/storage/{$finalPath}/{$finalName}";
                $bareImg = '<img src="' . $url . '" alt="">';
                $content = preg_replace('/\[\[IMG\]\]/', $bareImg, $content, 1);
            }
            return $content;
        }

        // Tidak ada token → append semua gambar di akhir (legacy)
        foreach ($finalNames as $finalName) {
            $content .= $this->imgTag($finalPath, $finalName);
        }
        return $content;
    }

    private function moveImage(string $imagesDir, string $base, string $finalPath, string $slot): ?string
    {
        $found = $this->findExtractedImage($imagesDir, $base);
        if (!$found) {
            return null;
        }

        $ext       = pathinfo($found, PATHINFO_EXTENSION);
        $finalName = "{$slot}.{$ext}";

        Storage::disk('public')->makeDirectory($finalPath);

        $contents = file_get_contents("{$imagesDir}/{$found}");
        Storage::disk('public')->put("{$finalPath}/{$finalName}", $contents);

        return $finalName;
    }

    private function locateXlsx(string $dir): ?string
    {
        foreach (glob("{$dir}/*.xlsx") as $f) {
            return $f;
        }
        foreach (glob("{$dir}/*/*.xlsx") as $f) {
            return $f;
        }
        return null;
    }

    private function cleanupOldTmp(string $tmpDir, int $maxAgeSeconds = 3600): void
    {
        if (!is_dir($tmpDir)) return;

        $now = time();

        foreach (glob("{$tmpDir}/review_*") as $path) {
            if (is_file($path) && ($now - filemtime($path)) > $maxAgeSeconds) {
                @unlink($path);
            }
        }

        foreach (glob("{$tmpDir}/review_extract_*") as $path) {
            if (is_dir($path) && ($now - filemtime($path)) > $maxAgeSeconds) {
                $this->rrmdir($path);
            }
        }
    }

    private function rrmdir(string $dir): void
    {
        if (!is_dir($dir)) return;
        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = "{$dir}/{$item}";
            is_dir($path) ? $this->rrmdir($path) : @unlink($path);
        }
        @rmdir($dir);
    }

    public function importFromExcel($file, $tryoutId = null)
    {
        if (is_string($file)) {
            return $this->importFromFile($file, $tryoutId);
        }
        return $this->importFromUpload($file, $tryoutId);
    }
}