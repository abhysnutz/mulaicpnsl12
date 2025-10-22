<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['order','tryout_id','topic_id','question','explanation'];

    public $timestamps = true;


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
