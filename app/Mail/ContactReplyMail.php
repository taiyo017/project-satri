<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $messageContent;

    public function __construct(string $name, string $messageContent)
    {
        $this->name = $name;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('Reply from ' . config('app.name') . ' Team')
            ->html($this->htmlTemplate());
    }

    private function htmlTemplate(): string
    {
        $name = e($this->name);
        $message = nl2br(e($this->messageContent));
        $brand = config('app.name');
        $primary = "#1865C4";

        return <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{$brand} – Reply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, sans-serif;">

    <!-- Outer Wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <!-- Email Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:{$primary}; padding:20px 30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">{$brand}</h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">

                            <p style="margin-top:0;">Hello <strong>{$name}</strong>,</p>

                            <p>
                                Thank you for reaching out to us. We have received your message and truly appreciate you taking the time to contact us.
                            </p>

                            <div style="
                                background:#f9fafb;
                                padding:15px;
                                border:1px solid #e5e7eb;
                                border-radius:6px;
                                font-size:14px;
                                color:#444;">
                                {$message}
                            </div>

                            <p style="margin-top:20px;">
                                Our team will get back to you shortly. If your inquiry is urgent, feel free to reply directly to this email.
                            </p>

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>{$brand} Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
                            © {$brand} — All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
HTML;
    }
}
