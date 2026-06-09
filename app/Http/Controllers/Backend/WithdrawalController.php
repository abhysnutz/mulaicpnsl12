<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->orderBy('id', 'DESC')->get();
        return view('backend.withdrawal.index', compact('withdrawals'));
    }

    public function update(Request $request)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($request->id);

        // Hanya request yang masih pending yang boleh diproses
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $status = $request->status;

        if ($status === 'approved') {
            $this->approve($withdrawal, $request->admin_note);
            return redirect()->back()->with('success', 'Penarikan disetujui & saldo dipotong.');
        }

        if ($status === 'rejected') {
            $withdrawal->update([
                'status'       => 'rejected',
                'admin_note'   => $request->admin_note,
                'processed_at' => Carbon::now(),
            ]);
            // Saldo tidak disentuh sama sekali
            return redirect()->back()->with('success', 'Penarikan ditolak. Saldo user tetap utuh.');
        }

        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    private function approve(Withdrawal $withdrawal, ?string $note): void
    {
        DB::transaction(function () use ($withdrawal, $note) {
            $user = $withdrawal->user;
            $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id]);

            // Lock baris wallet biar tidak ada race saat potong saldo
            $wallet = $wallet->lockForUpdate()->find($wallet->id);

            // Saldo bisa saja sudah berubah sejak request dibuat -> validasi ulang
            if ($withdrawal->amount > $wallet->balance) {
                throw new \RuntimeException('Saldo user tidak mencukupi untuk penarikan ini.');
            }

            // Potong saldo + tulis ledger (debit), referensi ke withdrawal
            $wallet->debit(
                $withdrawal->amount,
                "Penarikan saldo ke {$withdrawal->bank_name} - {$withdrawal->account_number}",
                $withdrawal
            );

            $withdrawal->update([
                'status'       => 'approved',
                'admin_note'   => $note,
                'processed_at' => Carbon::now(),
            ]);
        });
    }
}