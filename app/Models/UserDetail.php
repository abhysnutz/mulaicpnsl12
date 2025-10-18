<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'province_id',
        'city_id',
        'address',
        'education',
        'birth',
        'phone',
        'major',
        'referrer'
    ];


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
