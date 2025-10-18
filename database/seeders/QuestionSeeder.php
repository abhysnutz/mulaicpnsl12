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
        $questions = [
            [
                'tryout_id' => 1,
                'topic_id' => 1,
                'order' => 1,
                'question' => 'Apa sila pertama dalam Pancasila?',
                'explanation' => "A. Ketuhanan Yang Maha Esa → Jawaban benar karena ini sila pertama.\nB. Kemanusiaan yang Adil dan Beradab → Ini sila kedua.\nC. Persatuan Indonesia → Ini sila ketiga.\nD. Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan → Ini sila keempat.\nE. Keadilan Sosial bagi Seluruh Rakyat Indonesia → Ini sila kelima."
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 2,
                'order' => 2,
                'question' => 'Kapan UUD 1945 disahkan?',
                'explanation' => "A. 17 Agustus 1945 → Ini tanggal proklamasi.\nB. 18 Agustus 1945 → Jawaban benar, UUD 1945 disahkan sehari setelah proklamasi.\nC. 20 Mei 1908 → Hari Kebangkitan Nasional.\nD. 28 Oktober 1928 → Sumpah Pemuda.\nE. 1 Juni 1945 → Lahirnya Pancasila."
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 7,
                'order' => 3,
                'question' => 'Matahari : Siang = Bulan : ?',
                'explanation' => "A. Bintang → Tidak relevan.\nB. Malam → Jawaban benar, karena analoginya waktu munculnya.\nC. Kegelapan → Bukan pasangan langsung.\nD. Terang → Berlawanan makna.\nE. Awan → Tidak berhubungan langsung."
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 8,
                'order' => 4,
                'question' => 'Jika semua burung bisa terbang dan elang adalah burung, maka elang bisa...?',
                'explanation' => "A. Tidur → Tidak relevan dengan silogisme.\nB. Berjalan → Tidak sesuai dengan premis.\nC. Terbang → Jawaban benar, kesimpulan dari premis.\nD. Berenang → Tidak relevan.\nE. Melompat → Bukan hasil silogisme."
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 13,
                'order' => 5,
                'question' => 'Apa yang akan Anda lakukan jika ada warga yang mengeluh tentang pelayanan?',
                'explanation' => "A. Mendengarkan dan mencari solusi terbaik → Nilai tertinggi, respons empatik.\nB. Mengabaikan keluhan warga → Nilai rendah, tidak profesional.\nC. Menunda penyelesaian masalah → Kurang tanggap.\nD. Meminta maaf tanpa solusi → Tidak menyelesaikan masalah.\nE. Menyerahkan sepenuhnya ke atasan → Tanggung jawab tidak diambil."
            ],
            [
                'tryout_id' => 1,
                'topic_id' => 14,
                'order' => 6,
                'question' => 'Bagaimana cara Anda membangun kerja sama dalam tim?',
                'explanation' => "A. Bekerja sendiri agar cepat selesai → Kurang kolaboratif.\nB. Berkolaborasi dengan rekan kerja → Nilai tertinggi, membangun teamwork.\nC. Menunggu instruksi lebih lanjut → Kurang proaktif.\nD. Membantu jika diminta → Kurang inisiatif.\nE. Fokus pada pekerjaan sendiri → Tidak membangun jejaring."
            ],
        ];

        foreach ($questions as $data) {
            Question::create($data);
        }
    }
}
