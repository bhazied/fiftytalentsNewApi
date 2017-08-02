<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class sponsorshipEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $sponsorship;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Model\Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sponsorships.proposal')
            ->with([
                'url' => URL::to('/auth/login'),
                'link' => URL::to('/auth/register', ['token' => $this->sponsorship->token]),
                'sponsorship' => $this->sponsorship
            ]);
    }
}
