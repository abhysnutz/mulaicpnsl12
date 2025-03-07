<?php

namespace Database\Seeders;

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
            ['category' => 'TWK', 'name' => 'Pancasila'],
            ['category' => 'TWK', 'name' => 'UUD 1945'],
            ['category' => 'TWK', 'name' => 'Bhinneka Tunggal Ika'],
            ['category' => 'TWK', 'name' => 'Sejarah Indonesia'],
            ['category' => 'TWK', 'name' => 'Wawasan Kebangsaan'],
            ['category' => 'TWK', 'name' => 'Negara dan Pemerintahan'],
            
            // TIU (Tes Intelegensi Umum)
            ['category' => 'TIU', 'name' => 'Analogi'],
            ['category' => 'TIU', 'name' => 'Silogisme'],
            ['category' => 'TIU', 'name' => 'Aritmetika'],
            ['category' => 'TIU', 'name' => 'Deret Angka'],
            ['category' => 'TIU', 'name' => 'Pola Gambar'],
            ['category' => 'TIU', 'name' => 'Pemahaman Bacaan'],
            
            // TKP (Tes Karakteristik Pribadi)
            ['category' => 'TKP', 'name' => 'Pelayanan Publik'],
            ['category' => 'TKP', 'name' => 'Jejaring Kerja'],
            ['category' => 'TKP', 'name' => 'Sosial Budaya'],
            ['category' => 'TKP', 'name' => 'Teknologi Informasi'],
            ['category' => 'TKP', 'name' => 'Profesionalisme'],
        ];

        DB::table('question_topics')->insert($topics);
    }
}
