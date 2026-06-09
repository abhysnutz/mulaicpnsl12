<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->orderBy('id', 'DESC')->get();
        return view('backend.withdrawal.index', compact('withdrawals'));
    }

    public function update(Request $request)
    {
        $status = $request->status;

        try {
            DB::transaction(function () use ($request, $status) {
                // Lock baris withdrawal — request kedua nunggu di sini
                $withdrawal = Withdrawal::with('user')
                    ->lockForUpdate()
                    ->findOrFail($request->id);

                // Cek status DI DALAM lock. Request kedua lihat status sudah berubah.
                if ($withdrawal->status !== 'pending') {
                    throw new \RuntimeException('Permintaan ini sudah diproses sebelumnya.');
                }

                if ($status === 'approved') {
                    $user = $withdrawal->user;
                    $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id]);

                    // Lock wallet juga
                    $wallet = Wallet::lockForUpdate()->find($wallet->id);

                    if ($withdrawal->amount > $wallet->balance) {
                        throw new \RuntimeException('Saldo user tidak mencukupi untuk penarikan ini.');
                    }

                    $wallet->debit(
                        $withdrawal->amount,
                        "Penarikan saldo ke {$withdrawal->bank_name} - {$withdrawal->account_number}",
                        $withdrawal
                    );

                    $withdrawal->update([
                        'status'       => 'approved',
                        'admin_note'   => $request->admin_note,
                        'processed_at' => now(),
                    ]);
                } elseif ($status === 'rejected') {
                    $withdrawal->update([
                        'status'       => 'rejected',
                        'admin_note'   => $request->admin_note,
                        'processed_at' => now(),
                    ]);
                } else {
                    throw new \RuntimeException('Status tidak valid.');
                }
            });
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $msg = $status === 'approved'
            ? 'Penarikan disetujui & saldo dipotong.'
            : 'Penarikan ditolak. Saldo user tetap utuh.';

        return redirect()->back()->with('success', $msg);
    }
}