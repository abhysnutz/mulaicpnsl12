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
     * Token posisi gambar — HARUS sama dengan QuestionImportService::IMG_PLACEHOLDER.
     */
    private const EXPORT_IMG_TOKEN = '[[IMG]]';

    /**
     * Ganti SETIAP tag <img> di HTML menjadi token [[IMG]], TANPA mengganggu
     * formatting lain (<strong>, <p>, <br>, style text-align, dll).
     *
     * Tujuannya: export → import balik (round-trip) mempertahankan POSISI gambar.
     * Importer mengganti [[IMG]] kembali jadi <img> di posisi yg sama, dgn URL
     * fresh sesuai ID soal baru (tidak ada URL basi, tidak dobel).
     */
    protected function imagesToPlaceholder(?string $html): string
    {
        $html = (string) $html;
        if (trim($html) === '') {
            return '';
        }

        $html = preg_replace('/<img\b[^>]*>(?:<\/img>)?/i', self::EXPORT_IMG_TOKEN, $html);

        return trim($html);
    }

    /**
     * Kumpulkan SEMUA file gambar berurutan untuk satu slot di folder storage soal:
     *   {slot}      → gambar ke-1 (mis. explanation.jpg)
     *   {slot}-2    → gambar ke-2 (mis. explanation-2.jpg)
     *   {slot}-3    → …
     * Berhenti saat nomor berikutnya tidak ada.
     *
     * Mengembalikan array: [ ['ext'=>'jpg','rel'=>'question/12/explanation.jpg'], ... ]
     * Terurut sesuai posisi. Kosong bila gambar pertama tidak ada.
     *
     * Cermin dari QuestionImportService::collectSequentialImages().
     */
    private function collectSequentialExportImages(string $imagePath, string $slot): array
    {
        $find = function (string $base) use ($imagePath) {
            foreach (['png', 'jpg', 'jpeg', 'webp', 'gif'] as $ext) {
                $rel = "{$imagePath}/{$base}.{$ext}";
                if (Storage::disk('public')->exists($rel)) {
                    return ['ext' => $ext, 'rel' => $rel];
                }
            }
            return null;
        };

        $out = [];

        // Gambar pertama: tanpa suffix
        $first = $find($slot);
        if (!$first) {
            return [];
        }
        $out[] = $first;

        // Lanjut -2, -3, … sampai putus
        $n = 2;
        while (($next = $find("{$slot}-{$n}")) !== null) {
            $out[] = $next;
            $n++;
        }

        return $out;
    }

    /**
     * Bangun file ZIP berisi soal.xlsx + folder images/ dari koleksi soal.
     */
    protected function buildExportZip(Collection $questions, string $fileName)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Export Soal');

        $headers = [
            "Nomor", "Kategori", "Topik", "Soal",
            "A", "B", "C", "D", "E",
            "Jawaban Benar", "Penjelasan",
            "Score A", "Score B", "Score C", "Score D", "Score E",
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

        // 🔎 Cari file gambar tunggal (utk jawaban A–E yg tetap single).
        $findImage = function (string $imagePath, string $slot) {
            foreach (['png', 'jpg', 'jpeg', 'webp', 'gif'] as $ext) {
                $rel = "{$imagePath}/{$slot}.{$ext}";
                if (Storage::disk('public')->exists($rel)) {
                    return ['ext' => $ext, 'rel' => $rel];
                }
            }
            return null;
        };

        $rowIndex = 2;
        foreach ($questions->values() as $no => $q) {
            $nomor    = $no + 1; // nomor urut Excel = kunci penamaan gambar
            $answers  = $q->answers->sortBy('option')->values();
            $category = $q->topic->category ?? '';
            $topik    = $q->topic->name ?? '';

            $imagePath = "question/{$q->id}";

            // --- Gambar SOAL (multi): question-{n}, question-{n}-2, … ---
            foreach ($this->collectSequentialExportImages($imagePath, 'question') as $idx => $img) {
                $name = $idx === 0
                    ? "question-{$nomor}.{$img['ext']}"
                    : "question-{$nomor}-" . ($idx + 1) . ".{$img['ext']}";
                $imageMap["images/{$name}"] = Storage::disk('public')->path($img['rel']);
            }

            // --- Gambar PENJELASAN (multi): explanation-{n}, explanation-{n}-2, … ---
            foreach ($this->collectSequentialExportImages($imagePath, 'explanation') as $idx => $img) {
                $name = $idx === 0
                    ? "explanation-{$nomor}.{$img['ext']}"
                    : "explanation-{$nomor}-" . ($idx + 1) . ".{$img['ext']}";
                $imageMap["images/{$name}"] = Storage::disk('public')->path($img['rel']);
            }

            // --- Gambar JAWABAN A–E (tetap single) ---
            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
                if ($img = $findImage($imagePath, $opt)) {
                    $name = "answer-{$nomor}-{$opt}.{$img['ext']}";
                    $imageMap["images/{$name}"] = Storage::disk('public')->path($img['rel']);
                }
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

            // 🔑 HTML mentah: <img> → [[IMG]] (posisi gambar dipertahankan).
            $data = [
                $nomor,
                $category,
                $topik,
                $this->imagesToPlaceholder($q->question),
                $this->imagesToPlaceholder($answers[0]->answer ?? ''),
                $this->imagesToPlaceholder($answers[1]->answer ?? ''),
                $this->imagesToPlaceholder($answers[2]->answer ?? ''),
                $this->imagesToPlaceholder($answers[3]->answer ?? ''),
                $this->imagesToPlaceholder($answers[4]->answer ?? ''),
                $jawabanBenar,
                $this->imagesToPlaceholder($q->explanation ?? ''),
                $score[0] ?? 0,
                $score[1] ?? 0,
                $score[2] ?? 0,
                $score[3] ?? 0,
                $score[4] ?? 0,
            ];

            foreach ($data as $i => $value) {
                $col = $i + 1;
                $cell = Coordinate::stringFromColumnIndex($col) . $rowIndex;
                $sheet->getCell($cell)->setValueExplicit(
                    (string) $value,
                    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                );
            }

            $rowIndex++;
        }

        foreach (range(1, count($headers)) as $col) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

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