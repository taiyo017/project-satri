<?php

namespace App\Mail;

use App\Models\EmailLog;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Subscriber $subscriber,
        public string $emailSubject,
        public string $emailContent,
        public ?string $contentUrl,
        public EmailLog $emailLog
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.content-notification',
            with: [
                'subscriber' => $this->subscriber,
                'emailSubject' => $this->emailSubject,
                'emailContent' => $this->emailContent,
                'contentUrl' => $this->contentUrl,
                'emailLog' => $this->emailLog,
                'trackingPixelUrl' => route('email.track.open', $this->emailLog->tracking_token),
                'unsubscribeUrl' => route('subscription.unsubscribe', $this->subscriber->unsubscribe_token),
            ],
        );
    }
}
