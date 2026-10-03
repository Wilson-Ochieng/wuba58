<?php

namespace App\Mail;

use App\Models\Brochure;
use App\Models\BrochureLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BrochureDelivery extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Brochure $brochure,
        public BrochureLead $lead,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your brochure: ' . $this->brochure->title,
            replyTo: config('mail.contact_recipient', config('mail.from.address')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.brochure-delivery',
            with: [
                'brochure' => $this->brochure,
                'lead' => $this->lead,
                'downloadUrl' => $this->brochure->file_url,
            ],
        );
    }

    public function attachments(): array
    {
        if (! $this->brochure->hasMedia('file')) {
            return [];
        }

        $media = $this->brochure->getFirstMedia('file');

        return [
            Attachment::fromPath($media->getPath())
                ->as($this->brochure->slug . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}