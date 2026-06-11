<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([ 
            'name' => 'Syafri',
            'email' => 'maps.abhy25@gmail.com',
            'password' => bcrypt('M2APS2Ldoank'),
            'email_verified_at' => now(),
            'is_admin' => 1,
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'province_id' => 75,
            'city_id' => 445,
            'address' => 'Jl. Jend Sudirman',
            'education' => 'S2',
            'birth' => '1993-07-25',
            'phone' => '085240564750',
            'major' => 'Teknik Informatika',
            'referrer' => 'Google',
        ]);
    }
}
