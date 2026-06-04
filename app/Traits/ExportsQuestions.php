<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

trait ExportsQuestions
{
    /**
     * Bangun file ZIP berisi soal.xlsx + folder images/ dari koleksi soal.
     *
     * @param  \Illuminate\Support\Collection  $questions  Koleksi Question (with topic & answers)
     * @param  string  $fileName  Nama file ZIP yang akan diunduh
     */
    protected function buildExportZip(Collection $questions, string $fileName)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Export Soal');

        // ==========================
        // 📌 Header kolom
        // ==========================
        $headers = [
            "Nomor", "Kategori", "Topik", "Soal",
            "A", "B", "C", "D", "E",
            "Jawaban Benar", "Penjelasan",
            "Score A", "Score B", "Score C", "Score D", "Score E",
            "Gambar Soal", "Gambar Penjelasan",
            "Gambar A", "Gambar B", "Gambar C", "Gambar D", "Gambar E",
        ];

        foreach ($headers as $i => $header) {
            $col = $i + 1;
            $cell = Coordinate::stringFromColumnIndex($col) . '1';
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0070C0');
            $sheet->getStyle($cell)->getFont()->getColor()->setARGB('FFFFFFFF');
        }

        // 🗂️ Map gambar utk ZIP: [ 'images/question-1.png' => '/path/absolut' ]
        $imageMap = [];

        // 🔎 Cari file gambar dgn ekstensi apapun untuk slot tertentu.
        $findImage = function (string $imagePath, string $slot) {
            foreach (['png', 'jpg', 'jpeg', 'webp', 'gif'] as $ext) {
                $rel = "{$imagePath}/{$slot}.{$ext}";
                if (Storage::disk('public')->exists($rel)) {
                    return ['ext' => $ext, 'rel' => $rel];
                }
            }
            return null;
        };

        // ==========================
        // 📝 Isi data soal
        // ==========================
        $rowIndex = 2;
        foreach ($questions->values() as $no => $q) {
            $nomor    = $no + 1; // nomor urut Excel = kunci penamaan gambar
            $answers  = $q->answers->sortBy('option')->values();
            $category = $q->topic->category ?? '';
            $topik    = $q->topic->name ?? '';

            $imagePath = "question/{$q->id}";

            // --- Gambar soal ---
            $gambarSoal = '';
            if ($img = $findImage($imagePath, 'question')) {
                $gambarSoal = "question-{$nomor}.{$img['ext']}";
                $imageMap["images/{$gambarSoal}"] = Storage::disk('public')->path($img['rel']);
            }

            // --- Gambar penjelasan ---
            $gambarPenjelasan = '';
            if ($img = $findImage($imagePath, 'explanation')) {
                $gambarPenjelasan = "explanation-{$nomor}.{$img['ext']}";
                $imageMap["images/{$gambarPenjelasan}"] = Storage::disk('public')->path($img['rel']);
            }

            // --- Gambar jawaban A–E ---
            $gambarJawaban = [];
            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
                $namaFile = '';
                if ($img = $findImage($imagePath, $opt)) {
                    $namaFile = "answer-{$nomor}-{$opt}.{$img['ext']}";
                    $imageMap["images/{$namaFile}"] = Storage::disk('public')->path($img['rel']);
                }
                $gambarJawaban[] = $namaFile;
            }

            // Jawaban benar (TWK/TIU)
            $jawabanBenar = '';
            if ($category !== 'TKP') {
                foreach ($answers as $ans) {
                    if ($ans->score == 5) {
                        $jawabanBenar = $ans->option;
                        break;
                    }
                }
            }

            // Skor TKP
            $score = [];
            foreach ($answers as $ans) {
                $score[] = ($category === 'TKP') ? $ans->score : 0;
            }

            $data = [
                $nomor,
                $category,
                $topik,
                strip_tags($q->question),
                strip_tags($answers[0]->answer ?? ''),
                strip_tags($answers[1]->answer ?? ''),
                strip_tags($answers[2]->answer ?? ''),
                strip_tags($answers[3]->answer ?? ''),
                strip_tags($answers[4]->answer ?? ''),
                $jawabanBenar,
                strip_tags($q->explanation ?? ''),
                $score[0] ?? 0,
                $score[1] ?? 0,
                $score[2] ?? 0,
                $score[3] ?? 0,
                $score[4] ?? 0,
                $gambarSoal,
                $gambarPenjelasan,
                $gambarJawaban[0] ?? '',
                $gambarJawaban[1] ?? '',
                $gambarJawaban[2] ?? '',
                $gambarJawaban[3] ?? '',
                $gambarJawaban[4] ?? '',
            ];

            foreach ($data as $i => $value) {
                $col = $i + 1;
                $cell = Coordinate::stringFromColumnIndex($col) . $rowIndex;
                $sheet->setCellValue($cell, $value);
            }

            $rowIndex++;
        }

        // 🪄 Auto lebar kolom
        foreach (range(1, count($headers)) as $col) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

        // ==========================
        // 💾 Tulis Excel ke temp, bungkus jadi ZIP
        // ==========================
        $tmpXlsx = tempnam(sys_get_temp_dir(), 'soal_') . '.xlsx';
        (new Xlsx($spreadsheet))->save($tmpXlsx);

        $tmpZip = tempnam(sys_get_temp_dir(), 'soalzip_') . '.zip';
        $zip = new \ZipArchive();
        $zip->open($tmpZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $zip->addFile($tmpXlsx, 'soal.xlsx');

        foreach ($imageMap as $zipName => $absPath) {
            if (is_file($absPath)) {
                $zip->addFile($absPath, $zipName);
            }
        }

        $zip->close();
        @unlink($tmpXlsx);

        return response()->download($tmpZip, $fileName)->deleteFileAfterSend(true);
    }
}