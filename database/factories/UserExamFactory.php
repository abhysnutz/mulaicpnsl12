<?php

namespace Database\Factories;

use App\Models\UserExam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserExamFactory extends Factory
{
    protected $model = UserExam::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // otomatis bikin user dummy juga
            'tryout_id' => 1,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes(100),
            'status' => 'In Progress',
        ];
    }

    /**
     * 🧪 State khusus untuk expired exam
     */
    public function expired()
    {
        return $this->state(fn (array $attributes) => [
            'end_time' => Carbon::now()->subMinutes(1),
            'status' => 'Expired',
        ]);
    }
}
