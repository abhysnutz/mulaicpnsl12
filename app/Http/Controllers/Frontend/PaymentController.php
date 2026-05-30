<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewPaymentNotificationMail;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

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
            $price = setting('package_price');
            $payment = Payment::Create([
                'user_id' => $user?->id,
                'whatsapp' => $request?->whatsapp ?? null,
                'payment_method_id' => $request?->payment_method_id,
                'unique_code' => $unique_code,
                'total' => $price + $unique_code
            ]);

            if($payment){
                // 📧 Kirim email ke owner
                try {
                    \Log::info('Mengirim email ke ' . config('services.owner_email'));
                    Mail::to(config('services.owner_email'))->send(new NewPaymentNotificationMail($payment));
                } catch (\Exception $e) {
                    \Log::error('Gagal kirim email: ' . $e->getMessage());
                }

                // 🔔 Kirim notif ke Telegram
                try {
                    $message = "🔔 *Permintaan Pembayaran Baru*\n\n"
                        . "Nama: " . $payment->user?->name . "\n"
                        . "Email: " . $payment->user?->email . "\n"
                        . "WhatsApp: " . ($payment->whatsapp ?? '-') . "\n"
                        . "Metode: " . ($payment->method?->name ?? '-') . "\n"
                        . "Nominal: Rp " . number_format($payment->total, 0, ',', '.') . "\n"
                        . "Tanggal: " . $payment->created_at->format('d M Y, H:i');

                    Http::post(
                        'https://api.telegram.org/bot' . config('services.telegram.bot_token') . '/sendMessage',
                        [
                            'chat_id' => config('services.telegram.chat_id'),
                            'text' => $message,
                            'parse_mode' => 'Markdown',
                        ]
                    );
                } catch (\Exception $e) {
                    \Log::error('Gagal kirim Telegram: ' . $e->getMessage());
                }
            }
        }

        return back()->with('status', 'payment-updated');
    }
}