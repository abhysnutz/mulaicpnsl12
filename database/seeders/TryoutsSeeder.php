<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TryoutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tryouts')->insert([
            [
                'title' => 'Tryout CPNS 2025 - Gelombang 1',
                'category' => 'Tryout',
                'access_type' => 'premium',
                'tryout_source_id' => 1, // Pastikan id ini ada di tabel tryout_sources
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Latihan Soal CPNS - TIU',
                'category' => 'Tryout',
                'access_type' => 'free',
                'tryout_source_id' => 2, // Pastikan id ini ada di tabel tryout_sources
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
