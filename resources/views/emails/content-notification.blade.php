<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 30px; border-radius: 10px;">
        <div style="background-color: white; padding: 30px; border-radius: 5px;">
            {!! $emailContent !!}
            
            @if($contentUrl)
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ route('email.track.click', ['token' => $emailLog->tracking_token, 'url' => $contentUrl]) }}" 
                       style="background-color: #2563eb; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                        View Full Details
                    </a>
                </div>
            @endif
        </div>
        
        <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">
        
        <div style="font-size: 12px; color: #999; text-align: center;">
            <p>You're receiving this email because you subscribed to our updates.</p>
            <p>
                <a href="{{ route('subscription.preferences', $subscriber->unsubscribe_token) }}" style="color: #2563eb;">Manage Preferences</a> | 
                <a href="{{ $unsubscribeUrl }}" style="color: #2563eb;">Unsubscribe</a>
            </p>
        </div>
    </div>
    
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixelUrl }}" width="1" height="1" alt="" style="display:none;">
</body>
</html>
