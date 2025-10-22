<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('M2APS2Ldoank'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * ✅ Setelah user dibuat, buat juga user_details otomatis.
     */
    public function configure()
    {
        return $this->afterCreating(function ($user) {
            $educationOptions = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];
            $referrerOptions = ['Google','Mesin pencari lainnya','YouTube','Instagram','Facebook','Teman atau Saudara','Iklan','Forum','Media sosial lainnya','Lainnya'];
            $provinceId = \App\Models\Province::inRandomOrder()->value('id');
            $cityId = \App\Models\City::inRandomOrder()->value('id');
            
            $user->detail()->create([
                'phone' => fake()->phoneNumber(),
                'birth' => fake()->date(),
                'province_id' => $provinceId,
                'city_id' => $cityId,
                'address' => fake()->address(),
                'education'   => fake()->randomElement($educationOptions),
                'major' => fake()->word(),
                'referrer' => fake()->randomElement($referrerOptions),
            ]);
        });
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
