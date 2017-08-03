<?php

namespace App\Events;

use App\Model\Sponsorship;
use App\Repositories\SponsorshipRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SponsorEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var SponsorshipRepository
     */
    public $sponsorship;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }
}
