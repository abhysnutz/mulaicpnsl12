<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guards = [];

    public function tryout(){
        return $this->belongsTo(Tryout::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function users(){
        return $this->hasMany(UserAnswer::class);
    }

    public function topic(){
        return $this->belongsTo(QuestionTopic::class);
    }
}
