<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutSource extends Model
{
    protected $guards = [];

    public function tryouts(){
        return $this->hasMany(Tryout::class);
    }
}
