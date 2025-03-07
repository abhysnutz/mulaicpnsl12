<?php

namespace App\Http\Middleware;

use App\Models\UserExam;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth; 

class EnsureUserNotInExam
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
            $activeExam = UserExam::where('user_id', $user->id)
                ->where('status', 'In Progress')
                ->first();

            if ($activeExam) {
                return redirect()->route('tryout.working', $activeExam->id)
                    ->with('warning', 'Anda masih dalam sesi ujian!');
            }
        }

        return $next($request);
    }
}
