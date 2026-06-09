<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::orderBy('name', 'ASC')->get();
        $users = User::with('referrer')->latest()->get();
        return view('backend.user.index', compact('users'));
    }

    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $user->suspend($request->reason);

        return back()->with('success', "Akun {$user->name} telah disuspend.");
    }

    public function unsuspend(User $user)
    {
        $user->unsuspend();

        return back()->with('success', "Suspend akun {$user->name} telah dibuka.");
    }
}