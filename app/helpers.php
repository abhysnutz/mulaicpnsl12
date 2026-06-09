<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('notif_telegram')) {
    function notif_telegram(string $message, ?string $chatId = null): void
    {
        try {
            $token  = config('services.telegram.bot_token');
            $chatId = $chatId ?? config('services.telegram.chat_id');

            if (! $token || ! $chatId) {
                return; // kredensial belum di-set, lewati
            }

            \Illuminate\Support\Facades\Http::post(
                'https://api.telegram.org/bot' . $token . '/sendMessage',
                [
                    'chat_id'    => $chatId,
                    'text'       => $message,
                    'parse_mode' => 'Markdown',
                ]
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal kirim Telegram: ' . $e->getMessage());
        }
    }
}