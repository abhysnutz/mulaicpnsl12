<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserExam;
use App\Models\Question;
use App\Models\UserAnswer;

class ExamTimerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 🧪 Test: User tidak bisa menyimpan jawaban setelah waktu ujian habis
     */
    public function test_user_cannot_save_answer_after_exam_expired()
    {
        // 1. Buat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. Buat exam yang sudah expired
        $exam = UserExam::factory()->create([
            'user_id' => $user->id,
            'end_time' => now()->subMinutes(1), // waktu sudah lewat 1 menit
        ]);

        // 3. Buat soal
        $question = Question::factory()->create([
            'tryout_id' => $exam->tryout_id,
        ]);

        // 4. Buat jawaban kosong dulu (karena real flow kamu generate ini saat start exam)
        UserAnswer::create([
            'user_exam_id' => $exam->id,
            'question_id' => $question->id,
            'answer_id' => null,
        ]);

        // 5. Kirim request untuk simpan jawaban (harusnya ditolak)
        $response = $this->postJson('/api/answer', [
            'exam_id' => $exam->id,
            'question_id' => $question->id,
            'answer_id' => 1
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'Waktu ujian telah habis.']);
    }

    /**
     * 🧪 Test: Jika user akses halaman ujian setelah expired → redirect
     */
    public function test_user_cannot_access_exam_page_after_expired()
    {
        // 1. Buat user & exam expired
        $user = User::factory()->create();
        $this->actingAs($user);

        $exam = UserExam::factory()->create([
            'user_id' => $user->id,
            'end_time' => now()->subMinutes(1),
        ]);

        // 2. User coba akses halaman ujian
        $response = $this->get("/tryout/{$exam->id}/ujian");

        // 3. Harus redirect ke halaman hasil / tampilan ujian selesai
        $response->assertRedirect("/tryout/{$exam->id}/result");
    }
}
