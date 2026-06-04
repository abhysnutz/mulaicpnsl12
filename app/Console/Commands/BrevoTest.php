<?php

namespace App\Console\Commands;

use App\Services\BrevoMailer;
use Illuminate\Console\Command;

class BrevoTest extends Command
{
    protected $signature = 'brevo:test {email}';
    protected $description = 'Kirim email test via Brevo';

    public function handle(BrevoMailer $mailer): int
    {
        $email = $this->argument('email');

        $ok = $mailer->send(
            $email,
            'Test MULAICPNS via Brevo',
            '<h2>Berhasil!</h2><p>Email transaksional Brevo jalan di port 443.</p>',
        );

        $ok ? $this->info("Terkirim ke {$email}") : $this->error('Gagal — cek laravel.log');

        return $ok ? self::SUCCESS : self::FAILURE;
    }
}