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
    public function importFromExcel($file, $tryoutId = null)
    {
        $success = 0;
        $failed = 0;
        $log = [];

        // 🧾 Load file Excel
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        foreach ($rows as $index => $row) {
            if ($index === 1) continue; // Skip header
            $rowNumber = $index;

            try {
                // ======================
                // 🧠 Ambil data Excel
                // ======================
                $kategori      = trim($row['B'] ?? '');
                $topik         = trim($row['C'] ?? '');
                $soal          = trim($row['D'] ?? '');
                $penjelasan    = trim($row['K'] ?? '');

                $gambarSoal         = trim($row['P'] ?? '');
                $gambarPenjelasan   = trim($row['Q'] ?? '');
                $gambarJawaban = [
                    trim($row['R'] ?? ''),
                    trim($row['S'] ?? ''),
                    trim($row['T'] ?? ''),
                    trim($row['U'] ?? ''),
                    trim($row['V'] ?? ''),
                ];

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

                Log::info("📥 Import baris {$rowNumber}", [
                    'kategori' => $kategori,
                    'topik' => $topik,
                    'soal' => $soal,
                    'jawaban' => $jawaban,
                    'jawaban_benar' => $jawabanBenar,
                    'scores' => $scores,
                ]);

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
                // 🔸 Validasi jawaban minimal
                // ======================
                foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                    if (empty($jawaban[$i]) && empty($gambarJawaban[$i])) {
                        throw new Exception("Jawaban {$opt} kosong (teks & gambar).");
                    }
                }

                DB::beginTransaction();

                // ======================
                // 📝 Simpan soal
                // ======================
                $question = Question::create([
                    'topic_id'    => $topic->id,
                    'question'    => $soal,
                    'explanation' => $penjelasan ?: null,
                ]);

                $tmpPath   = "question/tmp/import";
                $finalPath = "question/{$question->id}";

                // ======================
                // 📸 Gambar soal
                // ======================
                if (!empty($gambarSoal) && Storage::disk('public')->exists("{$tmpPath}/{$gambarSoal}")) {
                    Storage::disk('public')->makeDirectory($finalPath);
                    Storage::disk('public')->move("{$tmpPath}/{$gambarSoal}", "{$finalPath}/question.png");
                }

                // ======================
                // 📸 Gambar penjelasan
                // ======================
                if (!empty($gambarPenjelasan) && Storage::disk('public')->exists("{$tmpPath}/{$gambarPenjelasan}")) {
                    Storage::disk('public')->makeDirectory($finalPath);
                    Storage::disk('public')->move("{$tmpPath}/{$gambarPenjelasan}", "{$finalPath}/explanation.png");

                    $question->update([
                        'explanation' => ($penjelasan ? $penjelasan . '<br>' : '') .
                            "<img src='" . asset("storage/{$finalPath}/explanation.png") . "' alt=''>"
                    ]);
                }

                // ======================
                // 📸 Gambar jawaban A–E
                // ======================
                foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                    $imgFile = $gambarJawaban[$i];
                    if (!empty($imgFile) && Storage::disk('public')->exists("{$tmpPath}/{$imgFile}")) {
                        Storage::disk('public')->makeDirectory($finalPath);
                        Storage::disk('public')->move("{$tmpPath}/{$imgFile}", "{$finalPath}/{$opt}.png");
                        $jawaban[$i] = "<img src='" . asset("storage/{$finalPath}/{$opt}.png") . "' alt=''>";
                    }
                }

                // ======================
                // 💾 Simpan jawaban A–E
                // ======================
                foreach (['A', 'B', 'C', 'D', 'E'] as $i => $opt) {
                    $score = 0;
                    if ($topic->category === 'TKP') {
                        $score = max(1, (int)$scores[$i]);
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

                // 🔗 Jika tryout_id ada, langsung insert ke pivot
                if ($tryoutId) {
                    DB::table('question_tryout')->insert([
                        'tryout_id'   => $tryoutId,
                        'question_id' => $question->id,
                        'order'       => $rowNumber - 1
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
            'success' => $success,
            'failed'  => $failed,
            'log_file' => $log,
        ];
    }
}
