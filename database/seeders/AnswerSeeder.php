<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answers = [
            // Jawaban untuk soal kategori TWK
            ['question_id' => 1, 'option' => 'A', 'answer' => 'Ketuhanan Yang Maha Esa', 'score' => 5],
            ['question_id' => 1, 'option' => 'B', 'answer' => 'Kemanusiaan yang Adil dan Beradab', 'score' => 0],
            ['question_id' => 1, 'option' => 'C', 'answer' => 'Persatuan Indonesia', 'score' => 0],
            ['question_id' => 1, 'option' => 'D', 'answer' => 'Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan', 'score' => 0],
            ['question_id' => 1, 'option' => 'E', 'answer' => 'Keadilan Sosial bagi Seluruh Rakyat Indonesia', 'score' => 0],

            ['question_id' => 2, 'option' => 'A', 'answer' => '17 Agustus 1945', 'score' => 5],
            ['question_id' => 2, 'option' => 'B', 'answer' => '18 Agustus 1945', 'score' => 0],
            ['question_id' => 2, 'option' => 'C', 'answer' => '20 Mei 1908', 'score' => 0],
            ['question_id' => 2, 'option' => 'D', 'answer' => '28 Oktober 1928', 'score' => 0],
            ['question_id' => 2, 'option' => 'E', 'answer' => '1 Juni 1945', 'score' => 0],

            // Jawaban untuk soal kategori TIU
            ['question_id' => 3, 'option' => 'A', 'answer' => 'Bintang', 'score' => 0],
            ['question_id' => 3, 'option' => 'B', 'answer' => 'Malam', 'score' => 5],
            ['question_id' => 3, 'option' => 'C', 'answer' => 'Kegelapan', 'score' => 0],
            ['question_id' => 3, 'option' => 'D', 'answer' => 'Terang', 'score' => 0],
            ['question_id' => 3, 'option' => 'E', 'answer' => 'Awan', 'score' => 0],

            ['question_id' => 4, 'option' => 'A', 'answer' => 'Tidur', 'score' => 0],
            ['question_id' => 4, 'option' => 'B', 'answer' => 'Berjalan', 'score' => 0],
            ['question_id' => 4, 'option' => 'C', 'answer' => 'Terbang', 'score' => 5],
            ['question_id' => 4, 'option' => 'D', 'answer' => 'Berenang', 'score' => 0],
            ['question_id' => 4, 'option' => 'E', 'answer' => 'Melompat', 'score' => 0],

            // Jawaban untuk soal kategori TKP
            ['question_id' => 5, 'option' => 'A', 'answer' => 'Mendengarkan dan mencari solusi terbaik', 'score' => 5],
            ['question_id' => 5, 'option' => 'B', 'answer' => 'Mengabaikan keluhan warga', 'score' => 1],
            ['question_id' => 5, 'option' => 'C', 'answer' => 'Menunda penyelesaian masalah', 'score' => 2],
            ['question_id' => 5, 'option' => 'D', 'answer' => 'Meminta maaf tanpa solusi', 'score' => 3],
            ['question_id' => 5, 'option' => 'E', 'answer' => 'Menyerahkan sepenuhnya ke atasan', 'score' => 4],

            ['question_id' => 6, 'option' => 'A', 'answer' => 'Bekerja sendiri agar cepat selesai', 'score' => 1],
            ['question_id' => 6, 'option' => 'B', 'answer' => 'Berkolaborasi dengan rekan kerja', 'score' => 5],
            ['question_id' => 6, 'option' => 'C', 'answer' => 'Menunggu instruksi lebih lanjut', 'score' => 3],
            ['question_id' => 6, 'option' => 'D', 'answer' => 'Membantu jika diminta', 'score' => 2],
            ['question_id' => 6, 'option' => 'E', 'answer' => 'Fokus pada pekerjaan sendiri', 'score' => 4],
        ];

        DB::table('answers')->insert($answers);
    }
}
