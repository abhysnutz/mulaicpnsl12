<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedQuestionsAndAnswers('TWK', 30);
        $this->seedQuestionsAndAnswers('TIU', 35);
        $this->seedQuestionsAndAnswers('TKP', 45);
    }

    private function seedQuestionsAndAnswers($category, $count)
    {
        $lastOrder = Question::where('tryout_id', 1)->max('order') ?? 0;

        for ($i = 1; $i <= $count; $i++) {
            $question = Question::create([
                'order' => $lastOrder + $i,
                'tryout_id' => 1, // Sesuaikan dengan tryout yang ada
                'topic_id' => ($category == 'TWK' ? rand(1, 5) : (($category == 'TIU') ? rand(6,15) : rand(16,21))), // Random topic
                'question' => "Ini adalah soal $category nomor " . ($lastOrder + $i),
                'explanation' => "Penjelasan soal nomor " . ($lastOrder + $i),
            ]);

            foreach (range('A', 'E') as $option) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'answer' => "Pilihan $option untuk soal $category nomor " . ($lastOrder + $i),
                    'score' => $category === 'TKP' ? rand(1, 5) : ($option === 'A' ? 5 : 0),
                ]);
            }
        }
    }
}
