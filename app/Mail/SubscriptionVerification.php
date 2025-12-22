<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionVerification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Subscriber $subscriber,
        public array $topics
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Subscription',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-verification',
            with: [
                'verificationUrl' => route('subscription.verify', $this->subscriber->verification_token),
                'subscriber' => $this->subscriber,
                'topics' => $this->topics,
            ],
        );
    }
}
