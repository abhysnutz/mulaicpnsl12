<?php

namespace App\Http\Controllers\Frontend;

use App\Models\QuestionTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionTimeController extends Controller
{
    public function start(Request $request)
    {
        $data = $request->validate([
            'user_exam_id' => 'required|integer',
            'question_id' => 'required|integer',
        ]);

        $qt = QuestionTime::firstOrNew([
            'user_exam_id' => $data['user_exam_id'],
            'question_id' => $data['question_id'],
        ]);

        // Mulai sesi baru: set started_at, kosongkan ended_at (duration tetap diakumulasi)
        $qt->started_at = now();
        $qt->ended_at = null;
        if (!$qt->exists) {
            $qt->duration = 0;
        }
        $qt->save();

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

        if ($qt && $qt->started_at && !$qt->ended_at) {
            $elapsed = abs($qt->started_at->diffInSeconds(now()));
            // Cap per sesi: lindungi dari idle/AFK dalam satu kunjungan
            $elapsed = min($elapsed, 300); // maks 5 menit per sesi

            $qt->ended_at = now();
            $qt->duration = (int) $qt->duration + $elapsed; // AKUMULASI
            $qt->save();
        }

        return response()->json(['status' => 'ended']);
    }
}
