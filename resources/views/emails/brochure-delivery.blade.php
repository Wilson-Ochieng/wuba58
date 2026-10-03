<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { margin: 0; padding: 0; background: #161515; font-family: -apple-system, 'Inter', sans-serif; color: #F4F0E8; }
        .wrap { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
        .card { background: #1e1e1e; border: 1px solid rgba(236,177,67,0.15); padding: 48px 40px; }
        .brand { font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; font-weight: 700; color: #ECB143; margin-bottom: 32px; }
        h1 { font-size: 26px; line-height: 1.15; margin: 0 0 20px; font-weight: 800; letter-spacing: -0.02em; color: #F4F0E8; }
        h1 span { background: linear-gradient(135deg, #EFC967 0%, #E48633 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        p { font-size: 15px; line-height: 1.7; color: #c5c2bd; margin: 0 0 18px; }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(236,177,67,0.4), transparent); margin: 32px 0; }
        .btn { display: inline-block; padding: 16px 32px; background: linear-gradient(135deg, #EFC967 0%, #ECB143 50%, #E48633 100%); color: #161515 !important; text-decoration: none; font-weight: 700; font-size: 12px; letter-spacing: 0.15em; text-transform: uppercase; margin: 12px 0 24px; }
        .meta { background: #161515; border-left: 2px solid #ECB143; padding: 16px 20px; margin: 24px 0; font-size: 13px; color: #9e9a94; line-height: 1.6; }
        .footer { font-size: 12px; color: #757575; line-height: 1.6; margin-top: 32px; padding-top: 24px; border-top: 1px solid #2e2e2e; }
        .footer a { color: #ECB143; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="brand">Wuba 58 City Models</div>

            <h1>Thank you, <span>{{ explode(' ', $lead->name)[0] }}.</span></h1>

            <p>Your brochure is attached to this email. Save it or share it with your team.</p>

            <div class="meta">
                <strong style="color: #c5c2bd;">{{ $brochure->title }}</strong><br>
                @if ($brochure->description)
                    {{ $brochure->description }}<br>
                @endif
                @if ($brochure->category)
                    Category: {{ $brochure->category }}
                @endif
            </div>

            @if ($downloadUrl)
                <a href="{{ $downloadUrl }}" class="btn">Download from our site →</a>
            @endif

            <div class="divider"></div>

            <p style="font-size: 14px; color: #9e9a94;">
                Want to discuss a project? Reply to this email or message us directly:
            </p>

            <p style="margin-top: 12px;">
                <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', '')) }}" style="color: #ECB143; text-decoration: none;">
                    WhatsApp
                </a>
                ·
                <a href="mailto:{{ \App\Models\Setting::get('contact.email') }}" style="color: #ECB143; text-decoration: none;">
                    {{ \App\Models\Setting::get('contact.email') }}
                </a>
            </p>

            <div class="footer">
                <strong style="color: #c5c2bd;">Wuba 58 City Models</strong><br>
                {!! nl2br(e(\App\Models\Setting::get('contact.address_physical', ''))) !!}
            </div>
        </div>
    </div>
</body>
</html>