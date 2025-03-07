<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = ['user_exam_id','total_twk','total_tiu','total_score','is_passed'];
}
