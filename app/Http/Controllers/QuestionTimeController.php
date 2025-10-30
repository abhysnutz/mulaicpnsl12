<?php

namespace App\Http\Controllers;

use App\Models\QuestionTime;
use Illuminate\Http\Request;

class QuestionTimeController extends Controller
{
    public function start(Request $request)
    {
        $data = $request->validate([
            'user_exam_id' => 'required|integer',
            'question_id' => 'required|integer',
        ]);

        $qt = QuestionTime::firstOrCreate(
            [
                'user_exam_id' => $data['user_exam_id'],
                'question_id' => $data['question_id'],
            ],
            ['started_at' => now()]
        );

        return response()->json(['status' => 'started', 'id' => $qt->id]);
    }

    public function end(Request $request)
    {
        $data = $request->validate([
            'user_exam_id' => 'required|integer',
            'question_id' => 'required|integer',
        ]);

        $qt = QuestionTime::where('user_exam_id', $data['user_exam_id'])
            ->where('question_id', $data['question_id'])
            ->first();

        if ($qt && !$qt->ended_at) {
            $qt->update([
                'ended_at' => now(),
                'duration' => abs($qt->started_at->diffInSeconds(now())),
            ]);
        }

        return response()->json(['status' => 'ended']);
    }
}
