<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([ 
            'name' => 'Syafri',
            'email' => 'maps.abhy25@gmail.com',
            'password' => bcrypt('asdasdasd'),
            'email_verified_at' => now(),
            'is_admin' => 1,
        ]);
    }
}
