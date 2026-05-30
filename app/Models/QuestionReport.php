<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionReport extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'exam_id',
        'type',
        'note',
        'status',
    ];

    // Relasi ke user pelapor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke soal yang dilaporkan
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi ke exam (opsional)
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}