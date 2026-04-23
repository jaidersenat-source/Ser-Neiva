<?php

namespace App\Mail;

use App\Models\ChurchRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChurchRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ChurchRequest $churchRequest,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Nueva solicitud de registro — ' . $this->churchRequest->nombre_organizacion,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.church_request',
            with: [
                'req' => $this->churchRequest,
            ],
        );
    }
}
