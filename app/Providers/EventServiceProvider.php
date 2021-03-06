<?php

namespace App\Providers;

use App\Events\SponsorEvent;
use App\Listeners\AuthenticateSubscriber;
use App\Listeners\sponsorListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'Laravel\Passport\Events\AccessTokenCreated' => [
            AuthenticateSubscriber::class
        ],
        SponsorEvent::class => [
            sponsorListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
