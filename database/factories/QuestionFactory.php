<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'tryout_id' => 1,
            'topic_id' => 1,
            'question' => $this->faker->sentence(10),
        ];
    }
}
