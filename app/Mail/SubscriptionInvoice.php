<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Escort;

class SubscriptionInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;
    public Plan $plan;
    public Escort $escort;
    public string $expiresAt;

    public function __construct(Payment $payment, Plan $plan, Escort $escort, string $expiresAt)
    {
        $this->payment = $payment;
        $this->plan = $plan;
        $this->escort = $escort;
        $this->expiresAt = $expiresAt;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Factura de Suscripción - Citasescort (' . $this->plan->name . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-invoice',
        );
    }
}

