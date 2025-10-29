<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\Question;
use App\Models\Setting;
use App\Models\Tryout;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Cache;

class TryoutController extends Controller
{
    public function index(){
        $tryouts = Tryout::where('status','publish')->orderBy('id','DESC')->get();

        return view('frontend.tryout.index',compact('tryouts'));
    }

    public function prepare($id){
        $user = Auth::user();
        $tryout = Tryout::find($id);

        return view('frontend.tryout.prepare',compact('tryout'));
    }

    public function exam(Request $request){
        $result = ['status' => 0, 'data' => []];
        $user = Auth::user();

        // 1️⃣ Buat sesi ujian user
        $userExam = UserExam::create([
            'user_id'    => $user->id,
            'tryout_id'  => $request->tryout_id,
            'status'     => 'In Progress',
            'start_time' => now(),
            'end_time'   => now()->addMinutes(100),
        ]);

        if ($userExam) {
            // 2️⃣ Ambil semua soal
            $tryout = Tryout::with(['questions' => function ($q) {
                $q->orderBy('pivot_order', 'asc');
            }])->findOrFail($request->tryout_id);

            $questions = $tryout->questions;

            // 3️⃣ Simpan ke cache Redis
            $cacheKey = "tryout:{$user->id}:{$userExam->tryout_id}:questions";
            Cache::put($cacheKey, $questions, now()->addMinutes(120));

            // 4️⃣ Siapkan placeholder jawaban user
            $userAnswers = [];
            foreach ($questions as $question) {
                $userAnswers[] = [
                    'user_exam_id' => $userExam->id,
                    'question_id'  => $question->id,
                    'answer_id'    => null,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }
            UserAnswer::insert($userAnswers);

            // 5️⃣ Return ke frontend
            $result['status'] = 1;
            $result['data'] = $userExam->toArray();
        }

        return response()->json($result, 200);
    }

    public function working($id){
        $user = Auth::user();

        $exam = UserExam::where('id',$id)->where('status','In Progress')->first();
        if(!$exam){
            return back()->with('error','Tryout Tidak Ditemukan');
        }

        $tryout = Tryout::find($exam->tryout_id);

        return view('frontend.tryout.working',compact('exam','tryout'));
    }

    public function question(Request $request){
        $exam = UserExam::with('tryout')->findOrFail($request->exam_id);

        $userId   = $exam->user_id;
        $tryoutId = $exam->tryout_id;
        $index    = (int) $request->index;

        // 🔑 Key cache unik per user & tryout
        $cacheKey = "tryout:{$userId}:{$tryoutId}:questions";

        // 🧠 Ambil soal dari cache
        $questions = Cache::get($cacheKey);

        // ⚠️ Jika cache hilang, rebuild dari database
        if (!$questions) {
            $questions = $exam->tryout
                ->questions()
                ->with(['answers', 'topic'])
                ->orderBy('pivot_order', 'asc')
                ->get();

            // simpan ulang ke cache
            Cache::put($cacheKey, $questions, now()->addMinutes(120));
        }

        // 🚨 Jika index di luar jangkauan
        if (!isset($questions[$index])) {
            return response()->json(['error' => 'Pertanyaan Tidak Ditemukan'], 404);
        }

        $question = $questions[$index];

        // ✅ Ambil jawaban user sebelumnya
        $selected_answer = UserAnswer::where('user_exam_id', $exam->id)
            ->where('question_id', $question->id)
            ->value('answer_id');

        // ✨ Jawaban dari relasi yang sudah di-load
        $answers = $question->answers->map(function ($answer) {
            return [
                'id'     => $answer->id,
                'answer' => $answer->answer,
                'option' => $answer->option,
            ];
        });

        return response()->json([
            'question' => [
                'id'       => $question->id,
                'question' => $question->question,
                'answers'  => $answers,
                'topic'    => $question?->topic?->name,
            ],
            'selected_answer' => $selected_answer,
            'index'           => $index + 1,        // pagination 1-based
            'total'           => count($questions)  // total soal
        ], 200);
    }


    public function questions(Request $request){
        
        $result = [];
        $result['status'] = 0;
        $result['data'] = [];

        $exam = UserExam::where('id', $request->exam_id)->first();
        $questions = $exam?->tryout?->questions;
        $is_answers = UserAnswer::where('user_exam_id', $exam->id)->whereNotNull('answer_id')->pluck('question_id');
        $result['data'] = $questions;
        $result['is_answers'] = $is_answers;
        
        return response()->json($result, 200);
    }

    // Display time after refresh
   public function time(Request $request){
        $userExam = UserExam::findOrFail($request->exam_id);

        return response()->json([
            // Sertakan offset timezone server (WIB)
            'end_time' => \Carbon\Carbon::parse($userExam->end_time)->timezone('Asia/Jakarta')->toIso8601String(),
        ]);
    }

    // User save answer
    public function answer(Request $request){
        DB::table('user_answers')
            ->where('user_exam_id', $request->exam_id)
            ->where('question_id', $request->question_id)
            ->update([
                'answer_id' => $request->answer_id,
                'updated_at' => now(),
            ]);
    
        return response()->json(['success' => true]);
    }

    public function cancel($exam_id){
        $exam = UserExam::where('id', $exam_id)->where('user_id', Auth::id())->where('status', 'In Progress')->first();

        if (!$exam){
            return redirect()->route('dashboard.index')->with('error', 'Ujian tidak ditemukan atau sudah selesai.');
        }

        // 🛑 Ubah status ujian
        $exam->update(['status' => 'Cancel','end_time'  => Carbon::now() ]);

        // 🧹 Hapus cache soal user ini
        $cacheKey = "tryout:{$exam->user_id}:{$exam->tryout_id}:questions";
        Cache::forget($cacheKey);

        return redirect()->route('dashboard.index')->with('success', 'Ujian telah dibatalkan dan cache soal dihapus.');
    }

    public function finish($exam_id){
        // 🧭 Validasi ujian masih berlangsung
        $exam = UserExam::where('id', $exam_id)->where('user_id', Auth::id())->where('status', 'In Progress')->first();

        if (!$exam) {
            return redirect()->route('dashboard.index')->with('error', 'Ujian tidak ditemukan atau sudah selesai.');
        }

        // 🕒 Update status ujian menjadi Completed
        $exam->update(['status'    => 'Completed', 'end_time'  => Carbon::now() ]);

        // 🧮 Hitung nilai TWK, TIU, TKP
        $total_twk = 0;
        $total_tiu = 0;
        $total_tkp = 0;

        $user_answers = UserAnswer::where('user_exam_id', $exam_id)
            ->with(['answer.question.topic']) // pre-load relasi untuk efisiensi
            ->get();

        foreach ($user_answers as $user_answer) {
            $category = $user_answer?->answer?->question?->topic?->category;

            if ($category === 'TWK') {
                $total_twk += $user_answer?->answer?->score ?? 0;
            } elseif ($category === 'TIU') {
                $total_tiu += $user_answer?->answer?->score ?? 0;
            } elseif ($category === 'TKP') {
                $total_tkp += $user_answer?->answer?->score ?? 0;
            }
        }

        $total_score = $total_twk + $total_tiu + $total_tkp;

        // 🧪 Ambil passing grade dari tabel settings
        $passing_grade_twk = (int) Setting::where('key', 'passing_grade_twk')->value('value');
        $passing_grade_tiu = (int) Setting::where('key', 'passing_grade_tiu')->value('value');
        $passing_grade_tkp = (int) Setting::where('key', 'passing_grade_tkp')->value('value');

        $isPassed = $total_twk >= $passing_grade_twk &&
                    $total_tiu >= $passing_grade_tiu &&
                    $total_tkp >= $passing_grade_tkp;

        // 📝 Simpan hasil ujian ke exam_results
        ExamResult::create([
            'user_exam_id' => $exam_id,
            'total_twk'    => $total_twk,
            'total_tiu'    => $total_tiu,
            'total_tkp'    => $total_tkp,
            'total_score'  => $total_score,
            'is_passed'    => $isPassed,
        ]);

        // 🧹 Bersihkan cache soal untuk ujian ini
        $cacheKey = "tryout:{$exam->user_id}:{$exam->tryout_id}:questions";
        Cache::forget($cacheKey);

        // ✅ Redirect ke halaman hasil ujian
        return redirect()->route('tryout.result.statistic', $exam_id);
    }
}
