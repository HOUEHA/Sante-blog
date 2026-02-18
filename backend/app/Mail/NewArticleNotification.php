<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewArticleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvel article: ' . $this->article->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-article-notification',
            with: [
                'article' => $this->article,
                'articleUrl' => url('/article/' . $this->article->slug)
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
