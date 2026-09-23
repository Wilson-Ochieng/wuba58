<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
    <style>
        body { font-family: -apple-system, sans-serif; background: #f4f0e8; padding: 30px; color: #2e2d2c; }
        .wrap { max-width: 600px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 4px; }
        .brand { font-size: 12px; letter-spacing: 0.2em; text-transform: uppercase; color: #a87c37; margin-bottom: 8px; }
        h1 { font-size: 22px; margin: 0 0 30px; }
        .row { padding: 12px 0; border-bottom: 1px solid #e5e0d5; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.15em; color: #7d5a3f; margin-bottom: 4px; }
        .value { font-size: 15px; }
        .message { white-space: pre-wrap; line-height: 1.6; padding: 20px 0; }
        .footer { margin-top: 30px; font-size: 12px; color: #8f8875; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand">Wuba 58 City Models</div>
        <h1>New Contact Message</h1>

        <div class="row">
            <div class="label">Name</div>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>

        <div class="row">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
        </div>

        @if ($contactMessage->phone)
            <div class="row">
                <div class="label">Phone</div>
                <div class="value">{{ $contactMessage->phone }}</div>
            </div>
        @endif

        @if ($contactMessage->company)
            <div class="row">
                <div class="label">Company</div>
                <div class="value">{{ $contactMessage->company }}</div>
            </div>
        @endif

        @if ($contactMessage->project_type)
            <div class="row">
                <div class="label">Project Type</div>
                <div class="value">{{ ucfirst(str_replace('_', ' ', $contactMessage->project_type)) }}</div>
            </div>
        @endif

        <div class="row">
            <div class="label">Message</div>
            <div class="message">{{ $contactMessage->message }}</div>
        </div>

        <div class="footer">
            Received {{ $contactMessage->created_at->format('M j, Y \a\t g:i A') }}<br>
            Reply directly to this email to reach {{ $contactMessage->name }}.
        </div>
    </div>
</body>
</html>