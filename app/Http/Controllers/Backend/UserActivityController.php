<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = UserActivity::with('user')->latest('created_at');

        // Filter opsional berdasarkan jenis aktivitas
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Pencarian opsional berdasarkan email/IP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('properties->email', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$search}%"));
            });
        }

        $activities = $query->paginate(30)->withQueryString();

        return view('backend.user-activity.index', compact('activities'));
    }
}