<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\CampaignController;
use App\Mail\CampaignMail;
use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        public Campaign $campaign,
    ) {}

    public function handle(): void
    {
        $this->campaign->load(['images', 'recipients.iglesia']);

        foreach ($this->campaign->recipients as $recipient) {
            $iglesia = $recipient->iglesia;
            if (!$iglesia) {
                continue;
            }

            $email = CampaignController::getEmail($iglesia);
            if (!$email) {
                continue;
            }

            Mail::to($email)
                ->send(new CampaignMail($this->campaign, $iglesia));

            $recipient->update(['sent_at' => now()]);

            // Pausa entre correos para respetar límites de Gmail
            usleep(500_000); // 0.5 segundos
        }

        $this->campaign->update([
            'status'  => 'sent',
            'sent_at' => now(),
        ]);
    }
}
