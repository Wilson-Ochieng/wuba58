<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\ContactReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyFromUser extends Mailable
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
            subject: 'New reply from ' . $this->message->name,
            replyTo: $this->message->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply-from-user',
            with: [
                'msg' => $this->message,
                'reply' => $this->reply,
            ],
        );
    }
}