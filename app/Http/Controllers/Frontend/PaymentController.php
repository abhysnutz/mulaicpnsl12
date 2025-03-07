<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;

class PaymentController extends Controller
{
    public function index(){
        $user = Auth::user();
        $payments = Payment::where('user_id', $user?->id)->orderBy('id','DESC')->get();
        $methods = PaymentMethod::orderBy('name','ASC')->get();
        $payment_pending = Payment::where('user_id', $user?->id)->where('status','pending')->orderBy('id','DESC')->first();
        return view('frontend.payment.index',compact('methods','payments','payment_pending'));
    }

    public function store(Request $request){
        $user = Auth::user();
        if($user){
            $unique_code = mt_rand(1, 999);
            $price = Setting::where('key', 'package_price')->value('value');
            Payment::Create([
                'user_id' => $user?->id,
                'whatsapp' => $request?->whatsapp ?? null,
                'payment_method_id' => $request?->payment_method_id,
                'unique_code' => $unique_code,
                'total' => $price + $unique_code
            ]);
        }

        return back()->with('status', 'payment-updated');
    }
}
