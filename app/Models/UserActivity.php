<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    const UPDATED_AT = null; // hanya punya created_at

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array', // JSON otomatis jadi array PHP
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper biar pencatatan ringkas dari mana saja
    public static function record(string $type, ?int $userId, string $description = null, array $properties = []): self
    {
        return static::create([
            'user_id'     => $userId,
            'type'        => $type,
            'description' => $description,
            'properties'  => $properties ?: null,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }

    // Tambahkan di dalam class UserActivity
    public function getDeviceLabelAttribute(): string
    {
        $ua = $this->user_agent ?? '';

        if ($ua === '') return 'Tidak diketahui';

        // Deteksi browser
        $browser = match (true) {
            str_contains($ua, 'Edg')     => 'Edge',
            str_contains($ua, 'Chrome')  => 'Chrome',
            str_contains($ua, 'Firefox') => 'Firefox',
            str_contains($ua, 'Safari')  => 'Safari',
            default                      => 'Browser lain',
        };

        // Deteksi OS / perangkat
        $os = match (true) {
            str_contains($ua, 'Android')                          => 'Android',
            str_contains($ua, 'iPhone'), str_contains($ua, 'iPad') => 'iOS',
            str_contains($ua, 'Windows')                          => 'Windows',
            str_contains($ua, 'Mac OS')                           => 'Mac',
            str_contains($ua, 'Linux')                            => 'Linux',
            default                                               => 'OS lain',
        };

        return "{$browser} · {$os}";
    }
}