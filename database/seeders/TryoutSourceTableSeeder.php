<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class TryoutSourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tryout_sources')->insert([
            [ 'name' => 'Teman ASN', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'name' => 'AYO CPNS', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'name' => 'Website D', 'created_at' => now(), 'updated_at' => now(), ],
        ]);
    }
}
