<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $payments = Payment::with('user')->orderBy('id','DESC')->get();
        return view('backend.payment.index',compact('payments'));
    }

    public function update(Request $request){
        $payment = Payment::find($request->id);
        $payment->status = $request->status;
        $payment->save();

        // Jika pembayaran dikonfirmasi, tambahkan atau perpanjang subscription
        if ($request->status === 'confirmed') {
            $this->addOrExtendSubscription($payment->user_id);
        }
    
        return redirect()->back()->with('success', 'Payment status updated successfully!');        
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
