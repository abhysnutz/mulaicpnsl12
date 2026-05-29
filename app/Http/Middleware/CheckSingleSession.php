<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // ⛔ Cek suspend DULU — ini yang jamin user suspended pasti ketendang
            if ($user->is_suspended) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('status', 'Akun Anda telah disuspend. Silakan hubungi admin.');
            }

            // Baru cek single-session (token)
            $sessionToken = session('user_session_token');

            if ($user->session_id !== $sessionToken) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('status', 'Akun Anda telah diakses pada perangkat lain. Silakan login kembali.');
            }
        }

        return $next($request);
    }
}