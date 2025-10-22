<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserExam extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','tryout_id','status','start_time','end_time'];

    public function tryout(){
        return $this->belongsTo(Tryout::class);
    }

    public function result(){
        return $this->hasOne(ExamResult::class);
    }
}