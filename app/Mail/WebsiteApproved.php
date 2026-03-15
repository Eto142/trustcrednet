<?php

namespace App\Mail;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebsiteApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Website $website) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Your TrustCredNet listing is now live — ' . $this->website->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.website-approved',
        );
    }
}
