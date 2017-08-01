<?php

namespace App\Mail;

use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class AddRecommendation extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Subscriber
     */
    private $subscriber;
    
    private $recommendation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, \App\Model\Recommendation $recommendation)
    {
        $this->subscriber = $subscriber;
        $this->recommendation = $recommendation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.register.recommendation')
            ->subject($this->subscriber->first_name . ' souhaite obtenir une recommandation de votre part')
            ->with(['reco' => $this->recommendation, 'subscriber' => $this->subscriber, 'url' => URL::to('/')]);
    }
}
