<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\Setting;
use App\Models\Tryout;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;

class ExamController extends Controller
{
    public function index(){
        $user = Auth::user();
        $exams = UserExam::where('user_id',$user->id)->orderBy('id','DESC')->get();
        return view('frontend.exam.index', compact('exams'));
    }

    public function statistic(Request $request, $id){
        $exam = UserExam::with(['result','tryout'])->findorfail($id);
        $data['passing_grade_twk'] = Setting::where('key', 'passing_grade_twk')->value('value');
        $data['passing_grade_tiu'] = Setting::where('key', 'passing_grade_tiu')->value('value');
        $data['passing_grade_tkp'] = Setting::where('key', 'passing_grade_tkp')->value('value');
        return view('frontend.exam.statistic',compact('exam','data'));
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
        $questions = $exam?->tryout?->questions()->pluck('id');
        $is_answers = UserAnswer::with('answer:id,score')->where('user_exam_id', $exam->id)->get();
        $result['data'] = $questions;
        $result['is_answers'] = $is_answers;
        
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
