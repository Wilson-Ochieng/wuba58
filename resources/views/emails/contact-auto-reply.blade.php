<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>We received your message</title>
    <style>
        body { margin: 0; padding: 0; background: #161515; font-family: -apple-system, 'Inter', sans-serif; color: #F4F0E8; }
        .wrap { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
        .card { background: #1e1e1e; border: 1px solid rgba(236,177,67,0.15); padding: 48px 40px; }
        .brand { font-family: 'Helvetica Neue', sans-serif; font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; font-weight: 700; color: #ECB143; margin-bottom: 32px; }
        h1 { font-size: 28px; line-height: 1.15; margin: 0 0 24px; font-weight: 800; letter-spacing: -0.02em; color: #F4F0E8; }
        h1 span { background: linear-gradient(135deg, #EFC967 0%, #E48633 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        p { font-size: 15px; line-height: 1.7; color: #c5c2bd; margin: 0 0 18px; }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(236,177,67,0.4), transparent); margin: 32px 0; }
        .quote { border-left: 2px solid #ECB143; padding: 8px 0 8px 20px; color: #9e9a94; font-style: italic; font-size: 14px; line-height: 1.6; margin: 24px 0; }
        .btn { display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #EFC967 0%, #ECB143 50%, #E48633 100%); color: #161515 !important; text-decoration: none; font-weight: 700; font-size: 12px; letter-spacing: 0.15em; text-transform: uppercase; margin: 24px 0; }
        .footer { font-size: 12px; color: #757575; line-height: 1.6; margin-top: 32px; padding-top: 24px; border-top: 1px solid #2e2e2e; }
        .footer a { color: #ECB143; text-decoration: none; }
        .label { font-size: 10px; letter-spacing: 0.25em; text-transform: uppercase; color: #ECB143; font-weight: 700; margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="brand">Wuba 58 City Models</div>

            <h1>Thank you, <span>{{ explode(' ', $msg->name)[0] }}.</span></h1>

            <p>We've received your message and a member of our team will be in touch within one business day.</p>

            <div class="divider"></div>

            <div class="label">Your message</div>
            <div class="quote">{{ $msg->message }}</div>

            <p>If you'd like to add anything — drawings, references, a timeline — you can continue the conversation directly:</p>

            <a href="{{ $replyUrl }}" class="btn">Continue the conversation →</a>

            <p style="font-size: 13px; color: #757575; margin-top: 24px;">
                Or reply directly to this email and we'll see it on the same thread.
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