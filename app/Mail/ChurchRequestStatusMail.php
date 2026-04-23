<?php

namespace App\Mail;

use App\Models\ChurchRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChurchRequestStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ChurchRequest $churchRequest,
        public string $nuevoEstado,
    ) {}

    public function envelope(): Envelope
    {
        $asunto = match($this->nuevoEstado) {
            'revisada'  => '🔍 Tu solicitud está siendo revisada — SER Neiva',
            'aprobada'  => '✅ ¡Tu solicitud fue aprobada! — SER Neiva',
            'rechazada' => '❌ Tu solicitud no pudo ser procesada — SER Neiva',
            default     => 'Actualización de tu solicitud — SER Neiva',
        };

        return new Envelope(subject: $asunto);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.church_request_status',
            with: [
                'req'    => $this->churchRequest,
                'estado' => $this->nuevoEstado,
            ],
        );
    }
}
