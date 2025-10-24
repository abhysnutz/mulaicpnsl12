<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    protected $fillable = ['title','category','access_type','status','tryout_source_id','duration'];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function source(){
        return $this->belongsTo(TryoutSource::class,'tryout_source_id');
    }

    public function userResults()
{
    return $this->hasManyThrough(
        ExamResult::class,
        UserExam::class,
        'tryout_id',
        'user_exam_id',
        'id',
        'id'
    )->where('user_exams.user_id', auth()->id());
}
public function lastUserResult()
{
    return $this->userResults()->latest()->first();
}
}
