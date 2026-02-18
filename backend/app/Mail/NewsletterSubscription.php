<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;

    public function __construct($newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenue sur Ma Santé, Ma responsabilité',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-subscription',
            with: [
                'email' => $this->newsletter->email,
                'subscribedAt' => $this->newsletter->subscribed_at
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
