<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { margin: 0; padding: 0; background: #161515; font-family: -apple-system, 'Inter', sans-serif; color: #F4F0E8; }
        .wrap { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
        .card { background: #1e1e1e; border: 1px solid rgba(236,177,67,0.15); padding: 48px 40px; }
        .brand { font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; font-weight: 700; color: #ECB143; margin-bottom: 32px; }
        h1 { font-size: 24px; line-height: 1.2; margin: 0 0 24px; font-weight: 800; letter-spacing: -0.02em; color: #F4F0E8; }
        p { font-size: 15px; line-height: 1.7; color: #c5c2bd; margin: 0 0 18px; }
        .reply { background: #161515; border-left: 3px solid #ECB143; padding: 20px 24px; margin: 24px 0; white-space: pre-wrap; line-height: 1.7; color: #F4F0E8; font-size: 15px; }
        .btn { display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #EFC967 0%, #ECB143 50%, #E48633 100%); color: #161515 !important; text-decoration: none; font-weight: 700; font-size: 12px; letter-spacing: 0.15em; text-transform: uppercase; margin: 20px 0; }
        .footer { font-size: 12px; color: #757575; line-height: 1.6; margin-top: 32px; padding-top: 24px; border-top: 1px solid #2e2e2e; }
        .footer a { color: #ECB143; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="brand">Wuba 58 City Models</div>

            <h1>Hi {{ explode(' ', $msg->name)[0] }},</h1>

            <p>Thanks for your enquiry. Here's our reply:</p>

            <div class="reply">{{ $reply->body }}</div>

            <p style="font-size: 14px; color: #9e9a94;">Have a follow-up? Continue the conversation:</p>

            <a href="{{ $replyUrl }}" class="btn">Reply on our site →</a>

            <p style="font-size: 13px; color: #757575; margin-top: 20px;">
                Or simply reply to this email — it goes straight to our team.
            </p>

            <div class="footer">
                <strong style="color: #c5c2bd;">Wuba 58 City Models</strong><br>
                {!! nl2br(e(\App\Models\Setting::get('contact.address_physical', ''))) !!}<br><br>
                <a href="tel:{{ \App\Models\Setting::get('contact.phone') }}">{{ \App\Models\Setting::get('contact.phone') }}</a> ·
                <a href="mailto:{{ \App\Models\Setting::get('contact.email') }}">{{ \App\Models\Setting::get('contact.email') }}</a>
            </div>
        </div>
    </div>
</body>
</html>