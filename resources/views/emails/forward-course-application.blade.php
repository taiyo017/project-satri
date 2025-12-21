<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $emailSubject ?? 'Message from ' . config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f6f9;
            padding: 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .email-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .email-body {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 20px;
        }

        .message-content {
            font-size: 15px;
            color: #4a5568;
            line-height: 1.8;
            margin-bottom: 25px;
            white-space: pre-line;
        }

        .info-box {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-left: 4px solid #1363C6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
        }

        .info-box-title {
            font-size: 13px;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-box-content {
            font-size: 16px;
            font-weight: 600;
            color: #1363C6;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }

        .signature {
            margin-top: 30px;
        }

        .signature p {
            margin: 4px 0;
            font-size: 15px;
            color: #4a5568;
        }

        .signature .company-name {
            font-weight: 600;
            color: #1a202c;
        }

        .email-footer {
            background: #f7fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .email-footer p {
            font-size: 13px;
            color: #718096;
            margin: 8px 0;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #1363C6;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        .copyright {
            color: #a0aec0;
            font-size: 12px;
            margin-top: 15px;
        }

        /* Button styles (if needed) */
        .button {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            margin: 20px 0;
            transition: transform 0.2s;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-header {
                padding: 30px 20px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .email-body {
                padding: 30px 20px;
            }

            .info-box {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">

        <!-- Header -->
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
            <p>Course Application Communication</p>
        </div>

        <!-- Body -->
        <div class="email-body">

            <!-- Greeting -->
            <div class="greeting">
                Dear {{ $applicantName }},
            </div>

            <!-- Message Content -->
            <div class="message-content">
                {{ $messageContent }}
            </div>

            <!-- Course Information Box -->
            <div class="info-box">
                <div class="info-box-title">Regarding Course</div>
                <div class="info-box-content">{{ $courseTitle }}</div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Additional Information -->
            <p style="font-size: 15px; color: #4a5568; margin-bottom: 20px;">
                If you have any questions or need further clarification, please don't hesitate to reach out to us.
                We appreciate your interest in enrolling in our course.
            </p>

            <!-- Signature -->
            <div class="signature">
                <p>Best regards,</p>
                <p class="company-name">{{ config('app.name') }} Education Team</p>
            </div>

        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="font-weight: 600; color: #1a202c; margin-bottom: 15px;">
                {{ config('app.name') }}
            </p>

            <p>
                This email was sent regarding your course application.<br>
                Please do not reply directly to this email.
            </p>

            {{-- Uncomment if you have social links
            <div class="social-links">
                <a href="#">Website</a> •
                <a href="#">LinkedIn</a> •
                <a href="#">Twitter</a>
            </div>
            --}}

            <div class="copyright">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>

    </div>
</body>

</html>
