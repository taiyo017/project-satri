<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Subscription</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 30px; border-radius: 10px;">
        <h1 style="color: #2563eb; margin-bottom: 20px;">Verify Your Email Subscription</h1>
        
        <p>Hello{{ $subscriber->name ? ' ' . $subscriber->name : '' }},</p>
        
        <p>Thank you for subscribing to our updates! Please verify your email address to start receiving notifications.</p>
        
        <div style="background-color: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0;">You've subscribed to:</h3>
            <ul>
                @foreach($topics as $topic)
                    <li>{{ $topic['name'] }}</li>
                @endforeach
            </ul>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $verificationUrl }}" 
               style="background-color: #2563eb; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                Verify Email Address
            </a>
        </div>
        
        <p style="font-size: 14px; color: #666;">
            If the button doesn't work, copy and paste this link into your browser:<br>
            <a href="{{ $verificationUrl }}" style="color: #2563eb;">{{ $verificationUrl }}</a>
        </p>
        
        <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #999;">
            If you didn't subscribe to our mailing list, please ignore this email.
        </p>
    </div>
</body>
</html>
