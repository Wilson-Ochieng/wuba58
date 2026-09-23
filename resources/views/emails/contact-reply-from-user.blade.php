<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, sans-serif; background: #f4f0e8; padding: 30px; color: #2e2d2c; }
        .wrap { max-width: 600px; margin: 0 auto; background: #fff; padding: 40px; }
        .brand { font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; color: #a87c37; font-weight: 700; margin-bottom: 8px; }
        h1 { font-size: 20px; margin: 0 0 24px; }
        .reply { border-left: 3px solid #ECB143; padding: 12px 0 12px 20px; margin: 24px 0; white-space: pre-wrap; line-height: 1.6; }
        .meta { font-size: 12px; color: #8f8875; padding-top: 20px; border-top: 1px solid #e5e0d5; margin-top: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background: #ECB143; color: #161515 !important; text-decoration: none; font-weight: 700; font-size: 12px; letter-spacing: 0.15em; text-transform: uppercase; margin-top: 12px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand">Wuba 58 City Models</div>
        <h1>{{ $msg->name }} sent a follow-up</h1>

        <div class="reply">{{ $reply->body }}</div>

        <a href="{{ route('filament.admin.resources.contact-messages.view', $msg) }}" class="btn">Open in admin →</a>

        <div class="meta">
            {{ $msg->email }} · {{ $msg->phone ?? 'no phone' }}<br>
            Original message received {{ $msg->created_at->format('M j, Y') }}
        </div>
    </div>
</body>
</html>