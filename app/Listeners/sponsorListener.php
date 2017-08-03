<?php

namespace App\Listeners;

use App\Events\SponsorEvent;
use App\Repositories\SponsorshipRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sponsorListener
{
    /**
     * @var SponsorshipRepository
     */
    private $sponsorshipRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SponsorshipRepository $sponsorshipRepository)
    {
        //
        $this->sponsorshipRepository = $sponsorshipRepository;
    }

    /**
     * Handle the event.
     *
     * @param  =SponsorEvent  $event
     * @return void
     */
    public function handle(SponsorEvent $event)
    {
        if ($event->sponsorship != null) {
            $this->sponsorshipRepository->update(['status' => 'accepted'], $event->sponsorship->id, $this->sponsorshipRepository->getModelKeyName());
        }
    }
}
