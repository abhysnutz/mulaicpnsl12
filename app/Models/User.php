<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'session_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function detail(){
        return $this->hasOne(UserDetail::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function subscription()
    {
        return $this->hasOne(UserSubscription::class);
    }

    // Method untuk menentukan status subscription
    public function getSubscriptionStatusAttribute()
    {
        if ($this->subscription && $this->subscription->end_date >= now()) {
            return 'premium';
        }
        return 'free';
    }
}