<?php

namespace App\Listeners;

use App\Repositories\SubscriberRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Events\AccessTokenCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthenticateSubscriber
{
    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SubscriberRepository $subscriberRepository)
    {
        //
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        DB::table('oauth_access_tokens')
            ->where('id', '<>', $event->tokenId)
            ->where('user_id', $event->userId)
            ->where('client_id', $event->clientId)
            ->update(['revoked' => true]);
        $subscriber = $this->subscriberRepository->find($event->userId);
        $attributes = [
                'last_connexion' =>Carbon::now(),
                'connexion_success' => $subscriber->connexion_success +1
            ];
        $this->subscriberRepository->update($attributes, $subscriber);
    }
}
