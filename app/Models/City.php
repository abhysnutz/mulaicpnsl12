<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guards = [];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
