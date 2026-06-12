<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutSource extends Model
{
    protected $fillable = ['name'];

    public function tryouts()
    {
        return $this->hasMany(Tryout::class, 'tryout_source_id');
    }
}