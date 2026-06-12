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
    /**
     * Placeholder posisi gambar di dalam konten cell.
     * Jika cell mengandung token ini, gambar di-inject PERSIS di posisinya.
     * Jika tidak ada, gambar di-append di akhir (perilaku lama).
     */
    private const IMG_PLACEHOLDER = '[[IMG]]';

    /**
     * Normalisasi teks penjelasan dari cell Excel menjadi HTML <p> per baris,
     * supaya formatnya SELARAS dengan seeder dan editor summernote.
     */
    private function normalizeExplanation(?string $text): ?string
    {
        $text = trim((string) $text);
        if ($text === '') {
            return null;
        }

        // Sudah HTML? jangan diutak-atik.
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

    /**
     * Normalisasi teks jawaban: buang wrapper <div> tunggal hasil copy
     * dari sumber luar. <div> adalah elemen block sehingga memaksa opsi
     * turun baris di bawah label (A. \n Tata Usaha). Hanya unwrap kalau
     * SELURUH isi cell adalah satu div — multi-div / nested dibiarkan.
     */
    private function normalizeAnswer(string $text): string
    {
        $text = trim($text);

        // <div>isi apapun tanpa div lain</div> → isi
        if (preg_match('/^<div[^>]*>(.*)<\/div>$/is', $text, $m)
            && stripos($m[1], '<div') === false
        ) {
            return trim($m[1]);
        }

        return $text;
    }

    /**
     * Bangun tag <img> dengan format yg SAMA seperti output Summernote:
     *   <p><img src="http://domain/storage/question/{id}/{slot}.{ext}"><br></p>
     */
    private function imgTag(string $finalPath, string $fileName): string
    {
        $url = asset("storage/{$finalPath}/{$fileName}");
        return '<p><img src="' . $url . '"><br></p>';
    }

    /**
     * Inject gambar ke dalam konten.
     * - Ada token [[IMG]]  → ganti token PERTAMA dgn <img> polos (tanpa wrapper
     *   <p>, karena token biasanya sudah berada di dalam <div>/<p> sendiri).
     * - Tidak ada token    → append di akhir dgn format Summernote (legacy).
     */
    private function injectImage(string $content, string $finalPath, string $fileName): string
    {
        if (str_contains($content, self::IMG_PLACEHOLDER)) {
            $url     = asset("storage/{$finalPath}/{$fileName}");
            $bareImg = '<img src="' . $url . '" alt="">';
            return preg_replace('/\[\[IMG\]\]/', $bareImg, $content, 1);
        }

        return $content . $this->imgTag($finalPath, $fileName);
    }

    /**
     * Jaring pengaman: buang token [[IMG]] yang tersisa supaya tidak pernah
     * tampil literal ke user (mis. token ditulis tapi file gambarnya tdk ada
     * — seharusnya sudah tertangkap validateRow, ini lapisan kedua).
     */
    private function stripLeftoverPlaceholders(string $content): string
    {
        return str_replace(self::IMG_PLACEHOLDER, '', $content);
    }

    /**
     * Cari file gambar di folder extract berdasarkan basis nama (tanpa ekstensi),
     * mendukung ekstensi apapun. Mengembalikan nama file lengkap atau null.
     */
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

    /**
     * Entry point utama untuk file hasil upload (UploadedFile).
     */
    public function importFromUpload($file, $tryoutId = null)
    {
        $ext  = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        return $this->importFromFile($path, $tryoutId, $ext);
    }

    /**
     * Entry point import dari path. Mendukung .zip (Excel + folder images/)
     * maupun .xlsx polos (tanpa gambar).
     */
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

    // =====================================================================
    // 🔍 MODE REVIEW (2 TAHAP)
    // =====================================================================

    /**
     * TAHAP 1 — Analisa (dry-run).
     * Simpan file upload ke tmp dengan token, validasi SEMUA baris TANPA
     * menyimpan ke DB. Mengembalikan ringkasan + detail per baris.
     */
    public function analyze($file, $tryoutId = null): array
    {
        $ext = strtolower($file->getClientOriginalExtension());

        $tmpDir = storage_path('app/tmp');
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        // 🧹 Sapu file review_* lama (>1 jam) yg tertinggal krn batal commit.
        // Cleanup "nebeng" di sini supaya tidak butuh cron/scheduler.
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

    /**
     * TAHAP 2 — Commit dari token hasil analyze().
     */
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

    /**
     * Tentukan sumber xlsx + images dari file tmp.
     * @return array [string $xlsxPath, ?string $imagesDir, ?string $cleanupDir]
     */
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

    /**
     * Validasi semua baris TANPA menulis ke DB.
     * @return array<int,array{row:int,number:int,status:string,label:string,reason:?string}>
     */
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

    /**
     * Validasi SATU baris. Mengembalikan pesan error (string) bila gagal,
     * atau null bila lolos. Dipakai analyze() (dry-run) DAN process() (commit)
     * supaya aturan validasi tidak pernah berbeda.
     */
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

        // Soal wajib punya teks ATAU gambar (question-{nomor}). Cegah soal "hantu".
        $soal       = trim($row['D'] ?? '');
        $hasSoalImg = $imagesDir
            && $this->findExtractedImage($imagesDir, "question-{$nomor}") !== null;

        if ($soal === '' && !$hasSoalImg) {
            return "Soal kosong (teks & gambar tidak ditemukan).";
        }

        // Token [[IMG]] dipakai tapi file gambarnya tidak ada di ZIP
        // → kemungkinan lupa memasukkan file, atau salah nama. Gagalkan
        //   di sini supaya soal tidak tersimpan bolong.
        $placeholderChecks = [
            ['D', "question-{$nomor}",    'Soal'],
            ['K', "explanation-{$nomor}", 'Penjelasan'],
            ['E', "answer-{$nomor}-A",    'Jawaban A'],
            ['F', "answer-{$nomor}-B",    'Jawaban B'],
            ['G', "answer-{$nomor}-C",    'Jawaban C'],
            ['H', "answer-{$nomor}-D",    'Jawaban D'],
            ['I', "answer-{$nomor}-E",    'Jawaban E'],
        ];
        foreach ($placeholderChecks as [$col, $base, $label]) {
            $val = (string) ($row[$col] ?? '');
            if (str_contains($val, self::IMG_PLACEHOLDER)) {
                $found = $imagesDir
                    ? $this->findExtractedImage($imagesDir, $base)
                    : null;
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
     * Deteksi tipe dari beberapa byte awal file.
     */
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

    /**
     * Extract ZIP ke folder temp, temukan soal.xlsx, proses, lalu bersihkan.
     */
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

    /**
     * Proses isi Excel dalam SATU transaction (all-or-nothing).
     * Jika ADA baris gagal validasi, SEMUA dibatalkan (rollback) & exception
     * dilempar. Validasi pakai validateRow() yg sama dgn tahap review.
     */
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
                    if ($file = $this->moveImage($imagesDir, "question-{$nomor}", $finalPath, 'question')) {
                        $questionHtml = $this->injectImage($questionHtml, $finalPath, $file);
                    }

                    if ($file = $this->moveImage($imagesDir, "explanation-{$nomor}", $finalPath, 'explanation')) {
                        $explanationHtml = $this->injectImage($explanationHtml, $finalPath, $file);
                    }

                    foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                        if ($file = $this->moveImage($imagesDir, "answer-{$nomor}-{$opt}", $finalPath, $opt)) {
                            $url = asset("storage/{$finalPath}/{$file}");

                            if (str_contains($jawaban[$i], self::IMG_PLACEHOLDER)) {
                                // Token di dalam teks jawaban → inject di posisi token
                                $jawaban[$i] = $this->injectImage($jawaban[$i], $finalPath, $file);
                            } else {
                                // Legacy: jawaban gambar = <img> saja (teks diabaikan
                                // krn selama ini jawaban bergambar memang tanpa teks)
                                $jawaban[$i] = '<img src="' . $url . '">';
                            }
                        }
                    }
                }

                // Jaring pengaman: token yg tersisa (apapun sebabnya) dibuang
                // supaya tidak pernah tampil literal "[[IMG]]" ke user.
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
     * Pindahkan gambar dari folder extract ke storage final.
     */
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

    /**
     * Cari file *.xlsx di dalam folder extract (cek root dulu, lalu subfolder).
     */
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

    /**
     * Sapu file tmp import yang tertinggal (review_* lebih tua dari $maxAgeSeconds).
     * Dipanggil saat analyze() supaya cleanup berjalan tanpa cron/scheduler.
     * Folder extract sisa (review_extract_*) yg mungkin yatim juga dibersihkan.
     */
    private function cleanupOldTmp(string $tmpDir, int $maxAgeSeconds = 3600): void
    {
        if (!is_dir($tmpDir)) return;

        $now = time();

        // File: review_{token}.{ext}
        foreach (glob("{$tmpDir}/review_*") as $path) {
            if (is_file($path) && ($now - filemtime($path)) > $maxAgeSeconds) {
                @unlink($path);
            }
        }

        // Folder extract yatim (kalau ada proses yg gagal di tengah)
        foreach (glob("{$tmpDir}/review_extract_*") as $path) {
            if (is_dir($path) && ($now - filemtime($path)) > $maxAgeSeconds) {
                $this->rrmdir($path);
            }
        }
    }

    /**
     * Hapus folder rekursif.
     */
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

    // ======================================================
    // 🔁 Backward compat
    // ======================================================
    public function importFromExcel($file, $tryoutId = null)
    {
        if (is_string($file)) {
            return $this->importFromFile($file, $tryoutId);
        }
        return $this->importFromUpload($file, $tryoutId);
    }
}