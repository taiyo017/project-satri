<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\EmailLog;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Subscriber $subscriber,
        public EmailCampaign $campaign,
        public EmailLog $emailLog
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaign->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.campaign',
            with: [
                'subscriber' => $this->subscriber,
                'campaign' => $this->campaign,
                'trackingPixelUrl' => route('email.track.open', $this->emailLog->tracking_token),
                'unsubscribeUrl' => route('subscription.unsubscribe', $this->subscriber->unsubscribe_token),
            ],
        );
    }
}
