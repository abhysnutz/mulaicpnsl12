<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('payment_methods')->insert([
            ['name' => 'BNI', 'account_number' => '0079959501', 'account_name' => 'Mohamad Syafri Lamato'],
            ['name' => 'BCA', 'account_number' => '7975934322', 'account_name' => 'Mohamad Syafri Lamato'],
            ['name' => 'JENIUS', 'account_number' => '90250162103', 'account_name' => 'Moh Syafri Lamato'],
            ['name' => 'SEABANK', 'account_number' => '901998467580', 'account_name' => 'Mohamad Syafri Lamato'],
            ['name' => 'JAGO', 'account_number' => '105708807627', 'account_name' => 'Moh Syafri Lamato'],
            ['name' => 'OVO', 'account_number' => '085240564750', 'account_name' => 'Moh Syafri Lamato'],
            ['name' => 'DANA', 'account_number' => '085240564750', 'account_name' => 'Moh Syafri Lamato'],
            ['name' => 'SHOPEE PAY', 'account_number' => '085240564750', 'account_name' => 'Abhysnutz'],
        ]);
    }
}
