<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Listeners\SendAdminNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends  ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        OrderPlaced::class => [
            SendAdminNotification::class
        ]
    ];

    public function boot(){

    }

    public function register()
    {

    }
}

