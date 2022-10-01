<?php

namespace App\Providers;

use App\Listeners\RequestMadeEventSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\SmsReceived' => [
            'App\Listeners\NoticeNeighbours',
        ],
        'App\Events\EmergencyReponseSmsReceived' => [
            'App\Listeners\EmergencyResponseSmsListener',
            'App\Listeners\PatternListener',
        ],
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

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        RequestMadeEventSubscriber::class,
    ];
}
