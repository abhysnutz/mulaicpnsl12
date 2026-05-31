<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ID tryout target
        $tryoutId = 1;

        $questions = [
            [
                'topic_id' => 1,
                'question' => 'Apa sila pertama dalam Pancasila?',
                'explanation' => "<p>A. Ketuhanan Yang Maha Esa → Jawaban benar karena ini sila pertama.</p><p>B. Kemanusiaan yang Adil dan Beradab → Ini sila kedua.</p><p>C. Persatuan Indonesia → Ini sila ketiga.</p><p>D. Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan → Ini sila keempat.</p><p>E. Keadilan Sosial bagi Seluruh Rakyat Indonesia → Ini sila kelima.</p>"
            ],
            [
                'topic_id' => 2,
                'question' => 'Kapan UUD 1945 disahkan?',
                'explanation' => "<p>A. 17 Agustus 1945 → Ini tanggal proklamasi.</p><p>B. 18 Agustus 1945 → Jawaban benar, UUD 1945 disahkan sehari setelah proklamasi.</p><p>C. 20 Mei 1908 → Hari Kebangkitan Nasional.</p><p>D. 28 Oktober 1928 → Sumpah Pemuda.</p><p>E. 1 Juni 1945 → Lahirnya Pancasila.</p>"
            ],
            [
                'topic_id' => 7,
                'question' => 'Matahari : Siang = Bulan : ?',
                'explanation' => "<p>A. Bintang → Tidak relevan.</p><p>B. Malam → Jawaban benar, karena analoginya waktu munculnya.</p><p>C. Kegelapan → Bukan pasangan langsung.</p><p>D. Terang → Berlawanan makna.</p><p>E. Awan → Tidak berhubungan langsung.</p>"
            ],
            [
                'topic_id' => 8,
                'question' => 'Jika semua burung bisa terbang dan elang adalah burung, maka elang bisa...?',
                'explanation' => "<p>A. Tidur → Tidak relevan dengan silogisme.</p><p>B. Berjalan → Tidak sesuai dengan premis.</p><p>C. Terbang → Jawaban benar, kesimpulan dari premis.</p><p>D. Berenang → Tidak relevan.</p><p>E. Melompat → Bukan hasil silogisme.</p>"
            ],
            [
                'topic_id' => 13,
                'question' => 'Apa yang akan Anda lakukan jika ada warga yang mengeluh tentang pelayanan?',
                'explanation' => "<p>A. Mendengarkan dan mencari solusi terbaik → Nilai tertinggi, respons empatik.</p><p>B. Mengabaikan keluhan warga → Nilai rendah, tidak profesional.</p><p>C. Menunda penyelesaian masalah → Kurang tanggap.</p><p>D. Meminta maaf tanpa solusi → Tidak menyelesaikan masalah.</p><p>E. Menyerahkan sepenuhnya ke atasan → Tanggung jawab tidak diambil.</p>"
            ],
            [
                'topic_id' => 14,
                'question' => 'Bagaimana cara Anda membangun kerja sama dalam tim?',
                'explanation' => "<p>A. Bekerja sendiri agar cepat selesai → Kurang kolaboratif.</p><p>B. Berkolaborasi dengan rekan kerja → Nilai tertinggi, membangun teamwork.</p><p>C. Menunggu instruksi lebih lanjut → Kurang proaktif.</p><p>D. Membantu jika diminta → Kurang inisiatif.</p><p>E. Fokus pada pekerjaan sendiri → Tidak membangun jejaring.</p>"
            ],
        ];

        foreach ($questions as $index => $data) {
            // insert ke tabel questions
            $question = Question::create($data);

            // attach ke pivot question_tryout
            $question->tryouts()->attach($tryoutId, [
                'order' => $index + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}