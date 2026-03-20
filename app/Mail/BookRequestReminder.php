<?php

namespace App\Mail;

use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookRequestReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public BookRequest $bookRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lembrete de Devolução — ' . $this->bookRequest->book->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-request-reminder',
        );
    }
}