<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTime extends Model
{
    protected $fillable = [
        'user_exam_id',
        'question_id',
        'started_at',
        'ended_at',
        'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userExam()
    {
        return $this->belongsTo(UserExam::class);
    }
}
