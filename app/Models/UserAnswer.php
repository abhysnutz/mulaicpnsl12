<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $fillable = ['user_exam_id','question_id','answer_id'];

    protected $appends = ['is_correct'];

    public function answer(){
        return $this->belongsTo(Answer::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    // Accessor untuk kolom 'is_correct'
    public function getIsCorrectAttribute()
    {
        if (!$this->answer) {
            return null;
        }

        // Jika score = 5, return true
        if ($this->answer->score === 5) {
            return true;
        }

        // Jika score < 5, return false
        return false;
    }
}
