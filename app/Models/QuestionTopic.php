<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTopic extends Model
{
    protected $guarded = [];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function material()
    {
        return $this->hasOne(Material::class);
    }
}
