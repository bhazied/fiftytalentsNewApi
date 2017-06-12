<?php

namespace App\Mail;

use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistred extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Subscriber
     */
    private $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.register.registerCandidate')
            ->subject(trans('register.register_email_subject'))
            ->with(['subscriber' => $this->subscriber])
            ->attach(
                public_path().'/packages/CGV_Fifty_Talents.pdf',
                ['as' => 'CGV_Fifty_Talents.pdf',  'mime' => 'application/pdf',]
            );
    }
}
