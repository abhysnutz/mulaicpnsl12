<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('settings')->insert([
            ['key' => 'package_price', 'value' => '50000', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'passing_grade_twk', 'value' => '65', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'passing_grade_tiu', 'value' => '80', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'passing_grade_tkp', 'value' => '166', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
