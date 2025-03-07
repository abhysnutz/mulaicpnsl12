<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class TryoutSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tryout_sources')->insert([
            [ 'name' => 'Website A', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'name' => 'Website B', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'name' => 'Website C', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'name' => 'Website D', 'created_at' => now(), 'updated_at' => now(), ],
        ]);
    }
}
