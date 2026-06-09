<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_after',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'amount'        => 'integer',
        'balance_after' => 'integer',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // Sumber transaksi (ReferralCommission / Withdrawal / dll)
    public function reference()
    {
        return $this->morphTo();
    }
}