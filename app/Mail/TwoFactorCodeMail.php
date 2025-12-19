<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $userName;

    /**
     * Create a new message instance.
     */
    public function __construct(string $code, string $userName)
    {
        $this->code = $code;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Two Factor Authentication Code')
            ->html($this->htmlTemplate());
    }

    /**
     * Build HTML content directly.
     */
    private function htmlTemplate(): string
    {
        $name = e($this->userName);
        $code = e($this->code);
        $brand = config('app.name');
        $primary = "#1363C6";

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$brand} – Two Factor Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden;">
                    <tr>
                        <td style="background:{$primary}; padding:20px 30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">{$brand}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">
                            <p style="margin-top:0;">Hello <strong>{$name}</strong>,</p>
                            <p>Use the following code to complete your login:</p>
                            <div style="
                                background:#f9fafb;
                                padding:15px;
                                border:1px solid #e5e7eb;
                                border-radius:6px;
                                font-size:24px;
                                font-weight:bold;
                                color:{$primary};
                                text-align:center;
                                letter-spacing:3px;">
                                {$code}
                            </div>
                            <p style="margin-top:20px;">
                                This code will expire in 10 minutes.
                            </p>
                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>{$brand} Team</strong>
                            </p>
                        </td>
                    </tr>
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
