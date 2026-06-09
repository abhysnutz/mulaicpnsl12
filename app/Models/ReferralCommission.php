<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCommission extends Model
{
    protected $fillable = [
        'referrer_id',
        'referee_id',
        'payment_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    // Yang menerima komisi (pengajak)
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // Yang memicu komisi (diajak, yang bayar)
    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}