<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id','option','answer','score'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function users(){
        return $this->hasMany(UserAnswer::class);
    }
}
