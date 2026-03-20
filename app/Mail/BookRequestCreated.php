<?php

namespace App\Mail;

use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\RateLimited;

class BookRequestCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public BookRequest $bookRequest,
        public bool $isAdmin = false
    ) {}

    public function envelope(): Envelope
    {
        $prefix = $this->isAdmin ? '[ADMIN]' : '';

        return new Envelope(
            subject: $prefix . 'Nova Requisição — ' . $this->bookRequest->book->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-request-created',
        );
    }

    public function middleware(){
        return [new RateLimited('mail')];
    }

}