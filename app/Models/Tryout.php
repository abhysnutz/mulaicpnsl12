<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    protected $guards = [];

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
