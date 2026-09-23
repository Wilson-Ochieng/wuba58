<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your message — Wuba 58 City Models',
            replyTo: config('mail.contact_recipient', config('mail.from.address')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-auto-reply',
            with: [
                'msg' => $this->contactMessage,
                'replyUrl' => $this->contactMessage->reply_url,
            ],
        );
    }
}