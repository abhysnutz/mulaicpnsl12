<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    protected $fillable = ['title','category','access_type','status','tryout_source_id','duration'];

    public function source(){
        return $this->belongsTo(TryoutSource::class,'tryout_source_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tryout')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderBy('order', 'asc'); // supaya soal urut
    }

   
}
