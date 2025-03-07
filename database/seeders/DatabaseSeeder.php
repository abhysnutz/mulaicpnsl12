<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UserSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(TryoutSourcesTableSeeder::class);
        $this->call(QuestionTopicsSeeder::class);
        $this->call(TryoutsSeeder::class);
        $this->call(QuestionAnswerSeeder::class);
        // $this->call(QuestionSeeder::class);
        // $this->call(AnswerSeeder::class);
    }
}
