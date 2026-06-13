<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\Tryout;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;
use DB;

class ExamController extends Controller
{
    public function index(){
        $user = Auth::user();
        $exams = UserExam::where('user_id',$user->id)->orderBy('id','DESC')->get();
        return view('frontend.exam.index', compact('exams'));
    }

    // public function statistic(Request $request, $id){
    //     $exam = UserExam::with(['result','tryout'])->findorfail($id);

    //     if($exam?->user_id != Auth::user()->id){
    //         return abort(404);
    //     }

    //     $data['passing_grade_twk'] = setting('passing_grade_twk');
    //     $data['passing_grade_tiu'] = setting('passing_grade_tiu');
    //     $data['passing_grade_tkp'] = setting('passing_grade_tkp');

    //     // === Analisis per topik ===
    //     // Semua soal di tryout ini + topiknya
    //     $questions = $exam->tryout->questions()
    //         ->with('topic:id,category,name')
    //         ->get();

    //     // Jawaban user (question_id => score yang didapat)
    //     $userAnswers = UserAnswer::with('answer:id,score')
    //         ->where('user_exam_id', $exam->id)
    //         ->get()
    //         ->keyBy('question_id');

    //     // Durasi pengerjaan per soal (keyed: question_id => duration)
    //     $durationMap = DB::table('question_times')
    //         ->where('user_exam_id', $exam->id)
    //         ->pluck('duration', 'question_id');

    //     $durations = $durationMap->values(); // untuk time_stats yang sudah ada

    //     $timeStats = [
    //         'total'   => (int) $durations->sum(),
    //         'avg'     => $durations->count() > 0 ? (int) round($durations->avg()) : 0,
    //         'longest' => (int) ($durations->max() ?? 0),
    //         'fastest' => (int) ($durations->filter(fn($d) => $d > 0)->min() ?? 0),
    //         'count'   => $durations->count(),
    //     ];
    //     $data['time_stats'] = $timeStats;

    //     $summary = ['benar' => 0, 'salah' => 0, 'kosong' => 0, 'terjawab_tkp' => 0, 'total' => $questions->count()];
    //     $topics = []; // key: "category|name"
    //     foreach ($questions as $q) {
    //         if (!$q->topic) continue;
    //         $cat  = $q->topic->category;
    //         $name = $q->topic->name;
    //         $key  = $cat . '|' . $name;

    //         if (!isset($topics[$key])) {
    //             $topics[$key] = [
    //                 'category'   => $cat,
    //                 'name'       => $name,
    //                 'total'      => 0,   // jumlah soal
    //                 'correct'    => 0,   // TWK/TIU: jumlah benar
    //                 'score_got'  => 0,   // TKP: skor didapat
    //                 'score_max'  => 0,   // TKP: skor maksimal
    //                 'duration'   => 0,   // total durasi (detik) topik ini
    //             ];
    //         }
    //         $topics[$key]['total']++;
    //         $topics[$key]['duration'] += (int) ($durationMap->get($q->id) ?? 0);

    //         $ua = $userAnswers->get($q->id);
    //         $gotScore = $ua?->answer?->score ?? 0;
    //         $dijawab = $ua !== null;

    //         if ($cat === 'TKP') {
    //             $topics[$key]['score_got'] += $gotScore;
    //             $topics[$key]['score_max'] += 5; // maksimal per soal TKP
    //             // TKP: tidak ada benar/salah, hanya dijawab / kosong
    //             if ($dijawab) $summary['terjawab_tkp']++;
    //             else          $summary['kosong']++;
    //         } else {
    //             // TWK/TIU: benar jika score > 0
    //             if (!$dijawab) {
    //                 $summary['kosong']++;
    //             } elseif ($gotScore > 0) {
    //                 $topics[$key]['correct']++;
    //                 $summary['benar']++;
    //             } else {
    //                 $summary['salah']++;
    //             }
    //         }
    //     }

    //     // Hitung persentase + rapikan
    //     $topicStats = [];
    //     foreach ($topics as $t) {
    //         if ($t['category'] === 'TKP') {
    //             $pct = $t['score_max'] > 0 ? round($t['score_got'] / $t['score_max'] * 100) : 0;
    //         } else {
    //             $pct = $t['total'] > 0 ? round($t['correct'] / $t['total'] * 100) : 0;
    //         }
    //         $t['pct'] = $pct;
    //         $topicStats[] = $t;
    //     }

    //     // Urutkan dari terlemah (pct terkecil dulu)
    //     usort($topicStats, fn($a, $b) => $a['pct'] <=> $b['pct']);

    //     $data['topic_stats'] = $topicStats;

    //     // Kelompokkan per kategori, tiap grup tetap urut dari terlemah
    //     $grouped = ['TWK' => [], 'TIU' => [], 'TKP' => []];
    //     foreach ($topicStats as $t) {
    //         $grouped[$t['category']][] = $t;
    //     }
    //     $data['topic_grouped'] = $grouped;
    //     $data['summary'] = $summary;
    //     // Agregasi ringkasan per kategori (untuk tab)
    //     $catSummary = [];
    //     foreach (['TWK','TIU','TKP'] as $cat) {
    //         $totalSoal = 0; $benar = 0; $salah = 0; $kosong = 0;
    //         $skorGot = 0; $skorMax = 0; $durasi = 0;
    //         foreach (($grouped[$cat] ?? []) as $t) {
    //             $totalSoal += $t['total'];
    //             $durasi    += $t['duration'];
    //             if ($cat === 'TKP') {
    //                 $skorGot += $t['score_got'];
    //                 $skorMax += $t['score_max'];
    //             } else {
    //                 $benar += $t['correct'];
    //             }
    //         }
    //         // Untuk TWK/TIU hitung salah & kosong dari summary global per soal —
    //         // tapi lebih akurat dihitung ulang di loop. Untuk sekarang derive sederhana:
    //         $catSummary[$cat] = [
    //             'total'    => $totalSoal,
    //             'benar'    => $benar,
    //             'score_got'=> $skorGot,
    //             'score_max'=> $skorMax,
    //             'duration' => $durasi,
    //             'topics'   => $grouped[$cat] ?? [],
    //         ];
    //     }
    //     $data['cat_summary'] = $catSummary;

    //     return view('frontend.exam.statistic',compact('exam','data'));
    // }

    public function statistic(Request $request, $id){
        $exam = UserExam::with(['result','tryout'])->findorfail($id);

        if($exam?->user_id != Auth::user()->id){
            return abort(404);
        }

        $data['passing_grade_twk'] = setting('passing_grade_twk');
        $data['passing_grade_tiu'] = setting('passing_grade_tiu');
        $data['passing_grade_tkp'] = setting('passing_grade_tkp');

        // Semua soal di tryout ini + topiknya
        $questions = $exam->tryout->questions()
            ->with('topic:id,category,name')
            ->get();

        // Jawaban user (question_id => UserAnswer)
        $userAnswers = UserAnswer::with('answer:id,score')
            ->where('user_exam_id', $exam->id)
            ->get()
            ->keyBy('question_id');

        // Durasi per soal (question_id => duration)
        $durationMap = DB::table('question_times')
            ->where('user_exam_id', $exam->id)
            ->pluck('duration', 'question_id');
        $durations = $durationMap->values();

        // Ringkasan global
        $summary = ['benar' => 0, 'salah' => 0, 'kosong' => 0, 'terjawab_tkp' => 0, 'total' => $questions->count()];

        $topics = []; // key: "category|name"
        foreach ($questions as $q) {
            if (!$q->topic) continue;
            $cat  = $q->topic->category;
            $name = $q->topic->name;
            $key  = $cat . '|' . $name;

            if (!isset($topics[$key])) {
                $topics[$key] = [
                    'category'   => $cat,
                    'name'       => $name,
                    'total'      => 0,
                    'correct'    => 0,   // TWK/TIU: benar
                    'wrong'      => 0,   // TWK/TIU: salah
                    'empty'      => 0,   // tidak dijawab
                    'score_got'  => 0,   // TKP: skor didapat
                    'score_max'  => 0,   // TKP: skor maksimal
                    'duration'   => 0,   // detik
                ];
            }
            $topics[$key]['total']++;
            $topics[$key]['duration'] += (int) ($durationMap->get($q->id) ?? 0);

            $ua = $userAnswers->get($q->id);
            $gotScore = $ua?->answer?->score ?? 0;
            $dijawab = $ua !== null;

            if ($cat === 'TKP') {
                $topics[$key]['score_got'] += $gotScore;
                $topics[$key]['score_max'] += 5;
                if ($dijawab) { $summary['terjawab_tkp']++; }
                else          { $summary['kosong']++; $topics[$key]['empty']++; }
            } else {
                if (!$dijawab) {
                    $summary['kosong']++;
                    $topics[$key]['empty']++;
                } elseif ($gotScore > 0) {
                    $topics[$key]['correct']++;
                    $summary['benar']++;
                } else {
                    $topics[$key]['wrong']++;
                    $summary['salah']++;
                }
            }
        }

        // Hitung persentase tiap topik
        $topicStats = [];
        foreach ($topics as $t) {
            if ($t['category'] === 'TKP') {
                $pct = $t['score_max'] > 0 ? round($t['score_got'] / $t['score_max'] * 100) : 0;
            } else {
                $pct = $t['total'] > 0 ? round($t['correct'] / $t['total'] * 100) : 0;
            }
            $t['pct'] = $pct;
            $topicStats[] = $t;
        }

        // Urut dari terlemah (untuk rekomendasi fokus)
        usort($topicStats, fn($a, $b) => $a['pct'] <=> $b['pct']);
        $data['topic_stats'] = $topicStats;

        // Kelompokkan per kategori (urut terlemah dalam grup)
        $grouped = ['TWK' => [], 'TIU' => [], 'TKP' => []];
        foreach ($topicStats as $t) {
            $grouped[$t['category']][] = $t;
        }
        $data['topic_grouped'] = $grouped;
        $data['summary'] = $summary;

        // Agregasi per kategori untuk tab
        $catMeta = [
            'TWK' => ['name' => 'Tes Wawasan Kebangsaan',   'val' => (int)($exam?->result?->total_twk ?? 0), 'pass' => (int)($data['passing_grade_twk'] ?? 65)],
            'TIU' => ['name' => 'Tes Intelegensia Umum',    'val' => (int)($exam?->result?->total_tiu ?? 0), 'pass' => (int)($data['passing_grade_tiu'] ?? 80)],
            'TKP' => ['name' => 'Tes Karakteristik Pribadi','val' => (int)($exam?->result?->total_tkp ?? 0), 'pass' => (int)($data['passing_grade_tkp'] ?? 166)],
        ];

        $catSummary = [];
        foreach (['TWK','TIU','TKP'] as $cat) {
            $totalSoal = 0; $benar = 0; $salah = 0; $kosong = 0;
            $terjawab = 0; $skorGot = 0; $skorMax = 0; $durasi = 0;
            foreach (($grouped[$cat] ?? []) as $t) {
                $totalSoal += $t['total'];
                $durasi    += $t['duration'];
                $benar     += $t['correct'];
                $salah     += $t['wrong'];
                $kosong    += $t['empty'];
                $skorGot   += $t['score_got'];
                $skorMax   += $t['score_max'];
            }
            $terjawab = $totalSoal - $kosong;
            $catSummary[$cat] = [
                'name'      => $catMeta[$cat]['name'],
                'score'     => $catMeta[$cat]['val'],
                'pass'      => $catMeta[$cat]['pass'],
                'is_passed' => $catMeta[$cat]['val'] >= $catMeta[$cat]['pass'],
                'total'     => $totalSoal,
                'benar'     => $benar,
                'salah'     => $salah,
                'kosong'    => $kosong,
                'terjawab'  => $terjawab,
                'score_got' => $skorGot,
                'score_max' => $skorMax,
                'duration'  => $durasi,
                'topics'    => $grouped[$cat] ?? [],
            ];
        }
        $data['cat_summary'] = $catSummary;

        // Statistik waktu global
        $data['time_stats'] = [
            'total'   => (int) $durations->sum(),
            'avg'     => $durations->count() > 0 ? (int) round($durations->avg()) : 0,
            'longest' => (int) ($durations->max() ?? 0),
            'fastest' => (int) ($durations->filter(fn($d) => $d > 0)->min() ?? 0),
            'count'   => $durations->count(),
        ];

        return view('frontend.exam.statistic', compact('exam','data'));
    }

    public function explanation(Request $request, $id){
        $exam = UserExam::with(['tryout'])->findorfail($id);
     
        if($exam?->user_id != Auth::user()->id){
            return abort(404);
        }

        return view('frontend.exam.explanation',compact('exam'));
    }

    public function questions(Request $request){
        
        $result = [];
        $result['status'] = 0;
        $result['data'] = [];

        $exam = UserExam::where('id', $request->exam_id)->first();
        $questions = $exam->tryout->questions()->select('questions.id')->orderBy('question_tryout.order')->pluck('questions.id');
        $is_answers = UserAnswer::with('answer:id,score')->where('user_exam_id', $exam->id)->get();
        $durations = DB::table('question_times')->where('user_exam_id', $exam->id)->pluck('duration', 'question_id');
        $result['data'] = $questions;
        $result['is_answers'] = $is_answers;
        $result['durations'] = $durations;
        
        return response()->json($result, 200);
    }

    public function answer(Request $request){
        $result = [];
        $result['status'] = 0;
        $result['data'] = [];

        $exam = UserExam::where('id', $request->exam_id)->first();
        $questions = $exam?->tryout?->questions;

        if (!$questions || !isset($questions[$request->index])) {
            return response()->json(['error' => 'No question found'], 404);
        }
        $question = $questions[$request->index];
        $answers = $question->answers;

        $check_answer = UserAnswer::with('answer:id,score,option')->where('user_exam_id', $exam->id)->where('question_id',$question->id)->first();

        return response()->json([
            'question' => [
                'id' => $question->id,
                'question' => $question->question,
                'explanation' => $question->explanation,
                'answers' => $answers->map(function ($answer) {
                    return [
                        'id' => $answer->id,
                        'answer' => $answer->answer,
                        'score' => $answer->score,
                        'option' => $answer->option,
                    ];
                }),
                'topic' => $question?->topic?->name
            ],
            'check_answer' => $check_answer,
            'index' => $request->index + 1, // Untuk pagination
            'total' => $questions->count()
        ],200);
            
    }

}
