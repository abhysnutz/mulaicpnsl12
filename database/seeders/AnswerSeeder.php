<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['question_id' => 1, 'explanation' => 'explanation A', 'answer' => 'Ketuhanan Yang Maha Esa', 'score' => 5],
            ['question_id' => 1, 'explanation' => 'explanation B', 'answer' => 'Kemanusiaan yang Adil dan Beradab', 'score' => 0],
            ['question_id' => 1, 'explanation' => 'explanation C', 'answer' => 'Persatuan Indonesia', 'score' => 0],
            ['question_id' => 1, 'explanation' => 'explanation D', 'answer' => 'Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan', 'score' => 0],
            ['question_id' => 1, 'explanation' => 'explanation E', 'answer' => 'Keadilan Sosial bagi Seluruh Rakyat Indonesia', 'score' => 0],

            ['question_id' => 2, 'explanation' => 'explanation A', 'answer' => '17 Agustus 1945', 'score' => 5],
            ['question_id' => 2, 'explanation' => 'explanation B', 'answer' => '18 Agustus 1945', 'score' => 0],
            ['question_id' => 2, 'explanation' => 'explanation C', 'answer' => '20 Mei 1908', 'score' => 0],
            ['question_id' => 2, 'explanation' => 'explanation D', 'answer' => '28 Oktober 1928', 'score' => 0],
            ['question_id' => 2, 'explanation' => 'explanation E', 'answer' => '1 Juni 1945', 'score' => 0],

            // Jawaban untuk soal kategori TIU
            ['question_id' => 3, 'explanation' => 'explanation A', 'answer' => 'Bintang', 'score' => 0],
            ['question_id' => 3, 'explanation' => 'explanation B', 'answer' => 'Malam', 'score' => 5],
            ['question_id' => 3, 'explanation' => 'explanation C', 'answer' => 'Kegelapan', 'score' => 0],
            ['question_id' => 3, 'explanation' => 'explanation D', 'answer' => 'Terang', 'score' => 0],
            ['question_id' => 3, 'explanation' => 'explanation E', 'answer' => 'Awan', 'score' => 0],

            ['question_id' => 4, 'explanation' => 'explanation A', 'answer' => 'Tidur', 'score' => 0],
            ['question_id' => 4, 'explanation' => 'explanation B', 'answer' => 'Berjalan', 'score' => 0],
            ['question_id' => 4, 'explanation' => 'explanation C', 'answer' => 'Terbang', 'score' => 5],
            ['question_id' => 4, 'explanation' => 'explanation D', 'answer' => 'Berenang', 'score' => 0],
            ['question_id' => 4, 'explanation' => 'explanation E', 'answer' => 'Melompat', 'score' => 0],

            // Jawaban untuk soal kategori TKP
            ['question_id' => 5, 'explanation' => 'explanation A', 'answer' => 'Mendengarkan dan mencari solusi terbaik', 'score' => 5],
            ['question_id' => 5, 'explanation' => 'explanation B', 'answer' => 'Mengabaikan keluhan warga', 'score' => 1],
            ['question_id' => 5, 'explanation' => 'explanation C', 'answer' => 'Menunda penyelesaian masalah', 'score' => 2],
            ['question_id' => 5, 'explanation' => 'explanation D', 'answer' => 'Meminta maaf tanpa solusi', 'score' => 3],
            ['question_id' => 5, 'explanation' => 'explanation E', 'answer' => 'Menyerahkan sepenuhnya ke atasan', 'score' => 4],

            ['question_id' => 6, 'explanation' => 'explanation A', 'answer' => 'Bekerja sendiri agar cepat selesai', 'score' => 1],
            ['question_id' => 6, 'explanation' => 'explanation B', 'answer' => 'Berkolaborasi dengan rekan kerja', 'score' => 5],
            ['question_id' => 6, 'explanation' => 'explanation C', 'answer' => 'Menunggu instruksi lebih lanjut', 'score' => 3],
            ['question_id' => 6, 'explanation' => 'explanation D', 'answer' => 'Membantu jika diminta', 'score' => 2],
            ['question_id' => 6, 'explanation' => 'explanation E', 'answer' => 'Fokus pada pekerjaan sendiri', 'score' => 4],
        ];

        DB::table('answers')->insert($answers);
    }
}
