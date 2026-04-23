<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IglesiaLoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $ip,
        public string $fechaHora,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Inicio de sesión — ' . $this->user->name . ' · SER Neiva',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.iglesia_login',
            with: [
                'user'     => $this->user,
                'ip'       => $this->ip,
                'fechaHora'=> $this->fechaHora,
            ],
        );
    }
}
