<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\PaymentStatusMail;
use App\Models\Payment;
use App\Models\ReferralCommission;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index(){
        $payments = Payment::with('user')->orderBy('id','DESC')->get();
        return view('backend.payment.index',compact('payments'));
    }

    public function update(Request $request)
    {
        $payment = Payment::findOrFail($request->id);
        $payment->status = $request->status;
        $payment->save();

        // Jika pembayaran dikonfirmasi
        if ($request->status === 'confirmed') {
            $this->addOrExtendSubscription($payment->user_id);

            // Beri komisi ke pengajak (jika user ini diajak via referral)
            $this->giveReferralCommission($payment);

            // kirim email ke user
            Mail::to($payment->user->email)
                ->queue(new PaymentStatusMail($payment, 'accepted'));
        }else{
            $message = $request->message ?? 'Bukti pembayaran tidak valid atau tidak sesuai.';
            Mail::to($payment->user->email)
                ->queue(new PaymentStatusMail($payment, 'rejected', $message));
        }

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Beri komisi referral 10% ke wallet pengajak.
     * Idempotent: 1 payment maksimal 1 komisi (dijaga unique payment_id).
     */
    private function giveReferralCommission(Payment $payment): void
    {
        $referee = $payment->user;

        // User ini tidak diajak siapa-siapa -> tidak ada komisi
        if (! $referee || ! $referee->referred_by) {
            return;
        }

        // Sudah pernah dibuatkan komisi untuk payment ini -> jangan dobel
        if (ReferralCommission::where('payment_id', $payment->id)->exists()) {
            return;
        }

        $referrer = User::find($referee->referred_by);
        if (! $referrer) {
            return;
        }

        // Hitung 10% dari harga paket saat ini
        $price = (int) setting('package_price');
        $commission = (int) floor($price * 0.10);

        if ($commission <= 0) {
            return;
        }

        DB::transaction(function () use ($referrer, $referee, $payment, $commission) {
            // Catat komisi
            $record = ReferralCommission::create([
                'referrer_id' => $referrer->id,
                'referee_id'  => $referee->id,
                'payment_id'  => $payment->id,
                'amount'      => $commission,
            ]);

            // Pastikan wallet ada, lalu kredit + catat ledger
            $wallet = $referrer->wallet()->firstOrCreate(['user_id' => $referrer->id]);
            $wallet->credit(
                $commission,
                "Komisi referral dari {$referee->name}",
                $record
            );
        });
    }

    private function addOrExtendSubscription($userId){
        $subscription = UserSubscription::where('user_id', $userId)->first();
        $now = Carbon::now();
        if ($subscription) {
            if ($subscription->end_date >= $now) {
                // Jika langganan masih aktif, perpanjang dari end_date
                $subscription->end_date = Carbon::parse($subscription->end_date)->addMonths(12);
            } else {
                // Jika langganan sudah expired, perbarui dari sekarang
                $subscription->start_date = $now;
                $subscription->end_date = $now->addMonths(12);
                $subscription->status = 'active';
            }
        } else {
            // Jika belum pernah berlangganan, buat data baru
            $subscription = new UserSubscription();
            $subscription->user_id = $userId;
            $subscription->start_date = $now;
            $subscription->end_date = $now->addMonths(12);
            $subscription->status = 'active';
        }
        $subscription->save();
    }
}