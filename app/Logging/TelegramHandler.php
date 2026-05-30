<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Http;

class TelegramHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        $token  = config('services.telegram.bot_token');
        $chatId = config('services.telegram.error_chat_id');

        if (! $token || ! $chatId) {
            return;
        }

        $text = "🚨 *ERROR di " . config('app.name') . "*\n\n"
            . "*Level:* {$record->level->name}\n"
            . "*Pesan:* " . mb_substr($record->message, 0, 1000) . "\n"
            . "*Waktu:* " . $record->datetime->format('d M Y H:i:s');

        try {
            Http::timeout(5)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Throwable $e) {
            // jangan sampai gagal kirim notif bikin app crash
        }
    }
}