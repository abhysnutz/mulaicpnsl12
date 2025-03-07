<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // Contoh soal kategori TWK
            [
                'tryout_id' => 1,
                'topic_id' => 1, // Pancasila
                'question' => 'Apa sila pertama dalam Pancasila?',
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 2, // UUD 1945
                'question' => 'Kapan UUD 1945 disahkan?',
            ],
            
            // Contoh soal kategori TIU
            [
                'tryout_id' => 1,
                'topic_id' => 7, // Analogi
                'question' => 'Matahari : Siang = Bulan : ?',
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 8, // Silogisme
                'question' => 'Jika semua burung bisa terbang dan elang adalah burung, maka elang bisa...?',
            ],
            
            // Contoh soal kategori TKP
            [
                'tryout_id' => 1,
                'topic_id' => 13, // Pelayanan Publik
                'question' => 'Apa yang akan Anda lakukan jika ada warga yang mengeluh tentang pelayanan?',
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 14, // Jejaring Kerja
                'question' => 'Bagaimana cara Anda membangun kerja sama dalam tim?',
            ],
        ];

        DB::table('questions')->insert($questions);
    }
}
