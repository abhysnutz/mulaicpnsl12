<?php

namespace Database\Seeders;

use App\Models\QuestionTopic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class QuestionTopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            // TWK (Tes Wawasan Kebangsaan)
            ['category' => 'TWK', 'name' => 'Nasionalisme'],
            ['category' => 'TWK', 'name' => 'Integritas'],
            ['category' => 'TWK', 'name' => 'Bela Negara'],
            ['category' => 'TWK', 'name' => 'Pilar Negara'],
            ['category' => 'TWK', 'name' => 'Bahasa Indonesia'],
            
            // TIU (Tes Intelegensi Umum)
            ['category' => 'TIU', 'name' => 'Verbal (Analogi)'],
            ['category' => 'TIU', 'name' => 'Verbal (Silogisme)'],
            ['category' => 'TIU', 'name' => 'Verbal (Logika Analitik)'],
            ['category' => 'TIU', 'name' => 'Numerik (Hitung Cepat)'],
            ['category' => 'TIU', 'name' => 'Numerik (Deret)'],
            ['category' => 'TIU', 'name' => 'Numerik (Perbandingan)'],
            ['category' => 'TIU', 'name' => 'Numerik (Soal Cerita)'],
            ['category' => 'TIU', 'name' => 'Figural (Analogi Gambar)'],
            ['category' => 'TIU', 'name' => 'Figural (Ketidaksamaan)'],
            ['category' => 'TIU', 'name' => 'Figural (Serial)'],
            
            // TKP (Tes Karakteristik Pribadi)
            ['category' => 'TKP', 'name' => 'Profesionalisme'],
            ['category' => 'TKP', 'name' => 'Pelayanan Publik'],
            ['category' => 'TKP', 'name' => 'Jejaring Kerja'],
            ['category' => 'TKP', 'name' => 'Sosial Budaya'],
            ['category' => 'TKP', 'name' => 'Teknologi Informasi dan Komunikasi'],
            ['category' => 'TKP', 'name' => 'Anti Radikalisme'],
        ];

        QuestionTopic::insert($topics);

        // DB::table('question_topics')->insert($topics);


        // 6 TWK - NASIONALISME
        // 6 TWK - INTEGRITAS
        // 6 TWK - BELA NEGARA
        // 6 TWK - PILAR NEGARA
        // 6 TWK - BAHASA INDONESIA
        // 4 TIU - VERBAL (ANALOGI)
        // 3 TIU - VERBAL (SILOGISME)
        // 4 TIU - VERBAL (LOGIKA ANALITIK)
        // 5 TIU - NUMERIK (HITUNG CEPAT) (GAMBAR)
        // 5 TIU - NUMERIK (DERET)
        // 4 TIU - NUMERIK (PERBANDINGAN) (GAMBAR)
        // 4 TIU - NUMERIK (SOAL CERITA) (GAMBAR)
        // 2 TIU - FIGURAL (ANALOGI GAMBAR) (GAMBAR)
        // 2 TIU - FIGURAL (KETIDAKSAMAAN) (GAMBAR)
        // 2 TIU - FIGURAL (SERIAL) (GAMBAR)
        // 8 TKP - PROFESIONALISME
        // 8 TKP - PELAYANAN PUBLIK
        // 8 TKP - JEJARING KERJA
        // 7 TKP - SOSIAL BUDAYA
        // 7 TKP - TEKNOLOGI INFORMASI DAN KOMUNIKASI
        // 7 TKP - ANTI RADIKALISME
    }
}
