<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'referred_by',
        'session_id',
        'is_suspended',
        'suspension_reason',
        'suspended_at',
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
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }

    // Auto-generate referral_code unik saat user dibuat (jika belum diisi)
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->referral_code)) {
                $user->referral_code = static::generateReferralCode();
            }
        });

        // Setiap user baru langsung punya wallet
        static::created(function (User $user) {
            $user->wallet()->create(['balance' => 0]);
        });
    }

    public static function generateReferralCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $code = '';
            for ($i = 0; $i < 5; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
        } while (static::where('referral_code', $code)->exists());

        return $code;
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

    // ===== Referral =====

    // User yang mengajak (pemilik kode yang dipakai saat daftar)
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    // Daftar user yang diajak oleh user ini
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    // Komisi yang diterima user ini (sebagai pengajak)
    public function commissions()
    {
        return $this->hasMany(ReferralCommission::class, 'referrer_id');
    }

    // ===== Wallet =====

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    // Method untuk menentukan status subscription
    public function getSubscriptionStatusAttribute()
    {
        if ($this->subscription && $this->subscription->end_date >= now()) {
            return 'premium';
        }
        return 'free';
    }

    // Cek apakah akun disuspend
    public function isSuspended(): bool
    {
        return $this->is_suspended;
    }

    // Suspend akun + putuskan sesi aktif sekaligus
    public function suspend(string $reason): void
    {
        $this->update([
            'is_suspended'      => true,
            'suspension_reason' => $reason,
            'suspended_at'      => now(),
            'session_id'        => null,
        ]);
    }

    // Buka suspend
    public function unsuspend(): void
    {
        $this->update([
            'is_suspended'      => false,
            'suspension_reason' => null,
            'suspended_at'      => null,
        ]);
    }
}