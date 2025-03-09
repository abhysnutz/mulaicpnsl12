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
}
