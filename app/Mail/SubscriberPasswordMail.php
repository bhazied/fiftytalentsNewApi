<?php

namespace App\Mail;

use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class SubscriberPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Subscriber
     */
    private $subscriber;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $newPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, $email, $newPassword)
    {
        //
        $this->subscriber = $subscriber;
        $this->email = $email;
        $this->newPassword = $newPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.register.forgotten')
            ->with([
                'url' => URL::to('/auth/login'),
                'email' => $this->email,
                'password' => $this->newPassword,
                'subscriber' => $this->subscriber
            ]);
    }
}
