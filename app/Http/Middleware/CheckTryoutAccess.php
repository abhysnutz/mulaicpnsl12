<?php

namespace App\Http\Middleware;

use App\Models\Tryout;
use App\Models\UserSubscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CheckTryoutAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tryout = Tryout::find($request->route('id')); // Ambil tryout berdasarkan ID dari route

        if (!$tryout) {
            return abort(404);
        }

        if ($tryout->access_type === 'premium') {
            // Cek apakah user memiliki langganan premium yang masih aktif
            $subscription = UserSubscription::where('user_id', Auth::id())
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->first();

            if (!$subscription) {
                return redirect()->route('tryout.index')->with('error', 'Maaf, tryout ini khusus untuk member paket Premium.');
            }
        }

        return $next($request);
    }
}
