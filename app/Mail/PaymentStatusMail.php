<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $payment;
    public $status; // accepted / rejected
    public $note;
    public $subscription;

    public function __construct($payment, $status, $note = null)
    {
        $this->payment = $payment;
        $this->status = $status;
        $this->note = $note ?? '';
        $this->subscription = $payment?->user?->subscription;
    }

    public function envelope(): Envelope
    {
        $subject = $this->status === 'accepted'
            ? 'Pembayaran Anda Diterima'
            : 'Pembayaran Anda Ditolak';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-status',
            with: [
                'payment' => $this->payment,
                'status' => $this->status,
                'note' => $this->note,
                'subscription' => $this->subscription,
            ]
        );
    }
}
