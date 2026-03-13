<?php

namespace App\Mail;

use App\Models\Campaign;
use App\Models\Iglesia;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Campaign $campaign,
        public Iglesia $iglesia,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaign->subject,
        );
    }

    public function content(): Content
    {
        $imageSrcs = [];

        foreach ($this->campaign->images as $img) {
            $fullPath = storage_path('app/public/' . $img->path);
            if (file_exists($fullPath)) {
                $cid  = md5($img->path) . '@sirn.neiva';
                $name = $img->original_name ?? basename($img->path);

                $imageSrcs[$img->id] = 'cid:' . $cid;

                $this->withSymfonyMessage(function (Email $message) use ($fullPath, $name, $cid) {
                    $part = DataPart::fromPath($fullPath, $name);
                    $part->asInline();
                    $part->setContentId($cid);
                    $message->addPart($part);
                });
            }
        }

        return new Content(
            view: 'emails.campaign',
            with: [
                'campaign'  => $this->campaign,
                'iglesia'   => $this->iglesia,
                'images'    => $this->campaign->images,
                'imageSrcs' => $imageSrcs,
            ],
        );
    }
}
