<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $id;
    protected string $title;
    protected string $emailSubject;
    protected string $author;

    /**
     * Create a new message instance.
     */
    public function __construct($id, $title, $emailSubject, $author)
    {
        $this->id           = $id;
        $this->title        = $title;
        $this->emailSubject = $emailSubject;
        $this->author       = $author;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.post-mail',
            with: [
                "id"     => $this->id,
                "title"  => $this->title,
                "author" => $this->author
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
