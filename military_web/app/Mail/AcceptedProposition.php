<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcceptedProposition extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $proposition, $post, $propositionAuthor, $postAuthor;
    public function __construct($proposition, $post, $propositionAuthor, $postAuthor)
    {
        $this->proposition=$proposition;
        $this->post=$post;
        $this->propositionAuthor = $propositionAuthor;
        $this->postAuthor = $postAuthor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Вашу пропозицію прийнято [Military Trade]',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails/proposition-accepted',
            with: ['proposition' => $this->proposition, 'post' => $this->post,'propositionAuthor'=>$this->propositionAuthor, 'postAuthor'=>$this->postAuthor],
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
