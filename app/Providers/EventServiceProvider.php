<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Listeners\CreateDonaturAfterRegister;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            CreateDonaturAfterRegister::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}