<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewPaymentNotificationMail;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Setting;
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
            $price = Setting::where('key', 'package_price')->value('value');
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
                    \Log::info('Mengirim email ke ' . env('OWNER_EMAIL'));
                    Mail::to(env('OWNER_EMAIL'))->send(new NewPaymentNotificationMail($payment));
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
                        'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage',
                        [
                            'chat_id' => env('TELEGRAM_CHAT_ID'),
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