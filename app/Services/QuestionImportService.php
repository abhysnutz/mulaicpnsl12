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
     * Bangun tag <img> dengan format yg SAMA seperti output Summernote:
     *   <p><img src="http://domain/storage/question/{id}/{slot}.{ext}"><br></p>
     */
    private function imgTag(string $finalPath, string $fileName): string
    {
        $url = asset("storage/{$finalPath}/{$fileName}");
        return '<p><img src="' . $url . '"><br></p>';
    }

    /**
     * Cari file gambar di folder extract berdasarkan basis nama (tanpa ekstensi),
     * mendukung ekstensi apapun. Mengembalikan nama file lengkap atau null.
     *
     * Contoh basis: "question-10", "explanation-3", "answer-5-A"
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
     * Mendeteksi tipe dari NAMA ASLI (bukan path temp Laravel yg tanpa ekstensi).
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  int|null  $tryoutId
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
     *
     * @param  string  $filePath  Path absolut file
     * @param  int|null  $tryoutId
     * @param  string|null  $extHint  Ekstensi asli ('zip'|'xlsx'|'xls') bila path temp tak punya ekstensi
     */
    public function importFromFile(string $filePath, $tryoutId = null, ?string $extHint = null)
    {
        $ext = $extHint ?: strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Fallback: kalau masih tak yakin, intip magic bytes file.
        if ($ext === '') {
            $ext = $this->detectByMagicBytes($filePath);
        }

        if ($ext === 'zip') {
            return $this->importFromZip($filePath, $tryoutId);
        }

        // .xlsx / .xls polos — tanpa gambar
        return $this->process($filePath, null, $tryoutId);
    }

    /**
     * Deteksi tipe dari beberapa byte awal file.
     * Catatan: .xlsx SEBENARNYA juga ZIP (PK..), jadi cek ini hanya dipakai
     * sebagai fallback terakhir & diasumsikan ZIP "kita" punya soal.xlsx di dalamnya.
     */
    private function detectByMagicBytes(string $filePath): string
    {
        $fh = @fopen($filePath, 'rb');
        if (!$fh) return '';
        $sig = fread($fh, 4);
        fclose($fh);

        // PK\x03\x04 = arsip ZIP (termasuk xlsx). Coba buka sebagai ZIP kita,
        // kalau ada soal.xlsx di dalam → anggap zip; kalau tidak → anggap xlsx.
        if (str_starts_with($sig, "PK")) {
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $hasXlsxInside = $zip->locateName('soal.xlsx', \ZipArchive::FL_NOCASE) !== false
                    || $zip->locateName('xl/workbook.xml') === false; // xlsx asli punya xl/workbook.xml
                // lebih akurat: kalau punya xl/workbook.xml → ini xlsx itu sendiri
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

        // Cari soal.xlsx (di root, atau di subfolder jika ZIP punya folder pembungkus)
        $xlsxPath = $this->locateXlsx($extractDir);
        if (!$xlsxPath) {
            $this->rrmdir($extractDir);
            throw new Exception('File soal.xlsx tidak ditemukan di dalam ZIP.');
        }

        $imagesDir = dirname($xlsxPath) . '/images';

        try {
            $result = $this->process($xlsxPath, is_dir($imagesDir) ? $imagesDir : null, $tryoutId);
        } finally {
            $this->rrmdir($extractDir); // selalu bersihkan temp
        }

        return $result;
    }

    /**
     * Proses isi Excel baris per baris. Jika $imagesDir ada, gambar
     * dipindahkan ke storage final & disisipkan sebagai <img> inline.
     */
    private function process(string $xlsxPath, ?string $imagesDir, $tryoutId = null)
    {
        $success = 0;
        $failed  = 0;
        $log     = [];

        $spreadsheet = IOFactory::load($xlsxPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows  = $sheet->toArray(null, true, true, true);

        // 🔢 Jika import ke tryout, lanjutkan order dari yg terakhir (jangan mulai dari 1)
        $nextOrder = 0;
        if ($tryoutId) {
            $nextOrder = (int) DB::table('question_tryout')
                ->where('tryout_id', $tryoutId)
                ->max('order');
        }

        foreach ($rows as $index => $row) {
            if ($index === 1) continue; // skip header
            $rowNumber = $index;

            try {
                // ======================
                // 🧠 Ambil data Excel
                //    Kolom geser +1 krn ada "Nomor" di kolom A.
                //    A=Nomor B=Kategori C=Topik D=Soal E–I=Jwb A–E
                //    J=Jwb benar K=Penjelasan L–P=Score A–E
                //    Q=Gbr soal R=Gbr penjelasan S–W=Gbr A–E
                // ======================
                $nomor      = (int) trim($row['A'] ?? 0);
                $kategori   = trim($row['B'] ?? '');
                $topik      = trim($row['C'] ?? '');
                $soal       = trim($row['D'] ?? '');
                $penjelasan = $this->normalizeExplanation($row['K'] ?? '');

                $jawaban = [
                    trim($row['E'] ?? ''),
                    trim($row['F'] ?? ''),
                    trim($row['G'] ?? ''),
                    trim($row['H'] ?? ''),
                    trim($row['I'] ?? ''),
                ];

                $jawabanBenar = strtoupper(trim($row['J'] ?? ''));

                $scores = [
                    (int)($row['L'] ?? 0),
                    (int)($row['M'] ?? 0),
                    (int)($row['N'] ?? 0),
                    (int)($row['O'] ?? 0),
                    (int)($row['P'] ?? 0),
                ];

                // Nama file gambar dari Excel (boleh kosong)
                $gambarSoal       = trim($row['Q'] ?? '');
                $gambarPenjelasan = trim($row['R'] ?? '');
                $gambarJawaban = [
                    trim($row['S'] ?? ''),
                    trim($row['T'] ?? ''),
                    trim($row['U'] ?? ''),
                    trim($row['V'] ?? ''),
                    trim($row['W'] ?? ''),
                ];

                // Baris kosong (tanpa kategori/topik) → skip diam-diam
                if ($kategori === '' && $topik === '' && $soal === '') {
                    continue;
                }

                // ======================
                // 🔎 Validasi topik
                // ======================
                $topic = QuestionTopic::where('category', $kategori)
                    ->where('name', $topik)
                    ->first();

                if (!$topic) {
                    throw new Exception("Topik tidak ditemukan: {$kategori} - {$topik}");
                }

                // ======================
                // 🔸 Validasi jawaban minimal (teks atau gambar)
                // ======================
                foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                    if (empty($jawaban[$i]) && empty($gambarJawaban[$i])) {
                        throw new Exception("Jawaban {$opt} kosong (teks & gambar).");
                    }
                }

                // ======================
                // 🔸 Validasi skor TKP: harus permutasi unik 1–5
                // ======================
                if ($topic->category === 'TKP') {
                    $sorted = $scores;
                    sort($sorted);
                    if ($sorted !== [1, 2, 3, 4, 5]) {
                        throw new Exception("Skor TKP harus permutasi unik 1–5, dapat: " . implode(',', $scores));
                    }
                }

                DB::beginTransaction();

                // ======================
                // 📝 Simpan soal (teks dulu)
                // ======================
                $question = Question::create([
                    'topic_id'    => $topic->id,
                    'question'    => $soal,
                    'explanation' => $penjelasan,
                ]);

                $finalPath = "question/{$question->id}";

                // ======================
                // 📸 Proses gambar (hanya jika ZIP punya folder images/)
                // ======================
                if ($imagesDir) {
                    $questionHtml    = $soal;
                    $explanationHtml = $penjelasan ?? '';

                    // --- Gambar soal: cari "question-{nomor}.*" ---
                    if ($file = $this->moveImage($imagesDir, "question-{$nomor}", $finalPath, 'question')) {
                        $questionHtml = $soal . $this->imgTag($finalPath, $file);
                    }

                    // --- Gambar penjelasan: "explanation-{nomor}.*" ---
                    if ($file = $this->moveImage($imagesDir, "explanation-{$nomor}", $finalPath, 'explanation')) {
                        $explanationHtml = ($penjelasan ?? '') . $this->imgTag($finalPath, $file);
                    }

                    // --- Gambar jawaban A–E: "answer-{nomor}-{opt}.*" ---
                    foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                        if ($file = $this->moveImage($imagesDir, "answer-{$nomor}-{$opt}", $finalPath, $opt)) {
                            // gambar jawaban: inline <img> langsung (tanpa <p>) spy rapi di opsi
                            $url = asset("storage/{$finalPath}/{$file}");
                            $jawaban[$i] = '<img src="' . $url . '">';
                        }
                    }

                    $question->update([
                        'question'    => $questionHtml,
                        'explanation' => $explanationHtml,
                    ]);
                }

                // ======================
                // 💾 Simpan jawaban A–E
                // ======================
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

                // 🔗 Pivot tryout — order lanjut dari yg sudah ada
                if ($tryoutId) {
                    $nextOrder++;
                    DB::table('question_tryout')->insert([
                        'tryout_id'   => $tryoutId,
                        'question_id' => $question->id,
                        'order'       => $nextOrder,
                    ]);
                }

                DB::commit();
                $success++;
                Log::info("✅ Sukses import baris {$rowNumber} [{$kategori} - {$topik}]");

            } catch (\Throwable $e) {
                DB::rollBack();
                $failed++;
                $message = "❌ Gagal import baris {$rowNumber}: " . $e->getMessage();
                Log::error($message, ['row_data' => $row]);
                $log[] = $message;
            }
        }

        return [
            'success'  => $success,
            'failed'   => $failed,
            'log_file' => $log,
        ];
    }

    /**
     * Pindahkan gambar dari folder extract ke storage final.
     * Mengembalikan nama file final (mis. "question.png") atau null jika tak ada.
     *
     * @param  string  $imagesDir  Folder images hasil extract
     * @param  string  $base       Basis nama di ZIP (mis. "question-10")
     * @param  string  $finalPath  Path relatif storage (mis. "question/55")
     * @param  string  $slot       Nama slot final ('question'|'explanation'|'A'..'E')
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

        // baca isi file & simpan via Storage (aman utk semua disk)
        $contents = file_get_contents("{$imagesDir}/{$found}");
        Storage::disk('public')->put("{$finalPath}/{$finalName}", $contents);

        return $finalName;
    }

    /**
     * Cari file *.xlsx di dalam folder extract (cek root dulu, lalu subfolder).
     */
    private function locateXlsx(string $dir): ?string
    {
        // root
        foreach (glob("{$dir}/*.xlsx") as $f) {
            return $f;
        }
        // subfolder satu level (kalau ZIP punya folder pembungkus)
        foreach (glob("{$dir}/*/*.xlsx") as $f) {
            return $f;
        }
        return null;
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
    // 🔁 Backward compat: kode lama masih panggil importFromExcel()
    // ======================================================
    public function importFromExcel($file, $tryoutId = null)
    {
        if (is_string($file)) {
            return $this->importFromFile($file, $tryoutId);
        }
        // UploadedFile → deteksi dari nama asli
        return $this->importFromUpload($file, $tryoutId);
    }
}