<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // Tangkap kode dari link ?ref=KODE untuk auto-isi field
        $refCode = $request->query('ref');

        return view('auth.register', [
            'refCode' => $refCode,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'confirmed', 'unique:'.User::class],
            // 'telepon' => ['required', 'numeric', 'digits_between:9,13'],
            'password' => ['required', 'confirmed'],
            'referral_code' => ['nullable', 'string', 'max:20'],
        ]);

        // Resolusi kode referral -> id pengajak. Kode salah/kosong = diabaikan (null).
        $referredBy = null;
        if ($request->filled('referral_code')) {
            $referrer = User::where('referral_code', strtoupper(trim($request->referral_code)))->first();
            $referredBy = $referrer?->id;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referred_by' => $referredBy,
        ]);

        if($user){
            UserDetail::create([
                'id' => $user?->id,
                'user_id' => $user?->id,
                'referrer' => $request->referrer ?? 'Google'
            ]);

            Mail::to($user->email)->queue(new WelcomeMail($user));
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.index', absolute: false));
    }
}