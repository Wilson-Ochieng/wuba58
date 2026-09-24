<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\ContactReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyFromAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $message,
        public ContactReply $reply,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: your enquiry — Wuba 58 City Models',
            replyTo: config('mail.contact_recipient', config('mail.from.address')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply-from-admin',
            with: [
                'msg' => $this->message,
                'reply' => $this->reply,
                'replyUrl' => $this->message->reply_url,
            ],
        );
    }
}