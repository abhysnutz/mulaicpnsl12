<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // Tambah saldo + catat ledger sekaligus. Panggil dalam DB transaction.
    public function credit(int $amount, ?string $description = null, ?Model $reference = null): WalletTransaction
    {
        $this->increment('balance', $amount);

        return $this->transactions()->create([
            'type'          => 'credit',
            'amount'        => $amount,
            'balance_after' => $this->balance,
            'description'   => $description,
            'reference_type'=> $reference?->getMorphClass(),
            'reference_id'  => $reference?->getKey(),
        ]);
    }

    // Kurangi saldo + catat ledger. Lempar exception kalau saldo kurang.
    public function debit(int $amount, ?string $description = null, ?Model $reference = null): WalletTransaction
    {
        if ($amount > $this->balance) {
            throw new \RuntimeException('Saldo tidak mencukupi.');
        }

        $this->decrement('balance', $amount);

        return $this->transactions()->create([
            'type'          => 'debit',
            'amount'        => $amount,
            'balance_after' => $this->balance,
            'description'   => $description,
            'reference_type'=> $reference?->getMorphClass(),
            'reference_id'  => $reference?->getKey(),
        ]);
    }
}