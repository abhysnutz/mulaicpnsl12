<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id','question','explanation'];

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function users(){
        return $this->hasMany(UserAnswer::class);
    }

    public function topic(){
        return $this->belongsTo(QuestionTopic::class);
    }

    public function tryouts()
    {
        return $this->belongsToMany(Tryout::class, 'question_tryout')
                    ->withPivot('order')
                    ->withTimestamps();
    }

    public function getCorrectAnswerAttribute(){
        return $this->answers->firstWhere('score', 5)?->option;
    }
}
