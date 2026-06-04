<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailer
{
    public function send(string $toEmail, string $subject, string $htmlContent, ?string $toName = null): bool
    {
        $config = config('services.brevo');

        $response = Http::withHeaders([
            'api-key' => $config['key'],
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => $config['from_name'],
                'email' => $config['from_email'],
            ],
            'to' => [[
                'email' => $toEmail,
                'name' => $toName ?? $toEmail,
            ]],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ]);

        if ($response->failed()) {
            Log::error('Brevo send failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }

        return true;
    }
}