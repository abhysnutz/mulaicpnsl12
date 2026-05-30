<?php

namespace App\Listeners;

use App\Models\UserActivity;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;

class LogAuthenticationActivity
{
    public function handleLogin(Login $event): void
    {
        UserActivity::record(
            type: 'login',
            userId: $event->user->getAuthIdentifier(),
            description: 'Login berhasil',
            properties: ['email' => $event->user->email],
        );
    }

    public function handleFailed(Failed $event): void
    {
        UserActivity::record(
            type: 'login_failed',
            userId: $event->user?->getAuthIdentifier(), // null kalau email tak terdaftar
            description: 'Login gagal',
            properties: ['email' => $event->credentials['email'] ?? 'unknown'],
        );
    }
}