<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan wallet ada (jaga-jaga user lama sebelum fitur ini)
        $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id]);

        $transactions = $wallet->transactions()
            ->latest()
            ->paginate(15);

        $withdrawals = $user->withdrawals()
            ->latest()
            ->take(10)
            ->get();

        // Statistik referral
        $totalReferrals = $user->referrals()->count();
        $totalCommission = $user->commissions()->sum('amount');

        return view('frontend.wallet.index', compact(
            'wallet',
            'transactions',
            'withdrawals',
            'totalReferrals',
            'totalCommission'
        ));
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id]);

        $minWithdrawal = (int) setting('min_withdrawal'); // 0 = bebas

        $request->validate([
            'amount'         => ['required', 'integer', 'min:1', 'max:' . $wallet->balance],
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name'   => ['required', 'string', 'max:100'],
        ], [
            'amount.max' => 'Jumlah melebihi saldo Anda.',
        ]);

        $amount = (int) $request->amount;

        // Cek minimum jika di-set (0 = bebas)
        if ($minWithdrawal > 0 && $amount < $minWithdrawal) {
            return back()->withErrors([
                'amount' => 'Minimal penarikan Rp ' . number_format($minWithdrawal, 0, ',', '.'),
            ])->withInput();
        }

        // Cegah ada request pending ganda
        if ($user->withdrawals()->where('status', 'pending')->exists()) {
            return back()->withErrors([
                'amount' => 'Anda masih punya permintaan penarikan yang sedang diproses.',
            ])->withInput();
        }

        Withdrawal::create([
            'user_id'        => $user->id,
            'amount'         => $amount,
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'status'         => 'pending',
        ]);

        notif_telegram(
            "💸 *Permintaan Penarikan Saldo*\n\n"
            . "Nama: " . $user->name . "\n"
            . "Jumlah: Rp " . number_format($amount, 0, ',', '.') . "\n"
            . "Bank: " . $request->bank_name . "\n"
            . "No. Rekening: " . $request->account_number . "\n"
            . "Atas Nama: " . $request->account_name . "\n"
            . "Tanggal: " . now()->format('d M Y, H:i')
        );

        return back()->with('success', 'Permintaan penarikan dikirim. Saldo akan dipotong setelah disetujui admin.');
    }
}