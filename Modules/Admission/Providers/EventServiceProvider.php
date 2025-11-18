<?php

namespace Modules\Admission\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Admission\Events\AdmissionContentEvent;
use Modules\Admission\Http\Listeners\AdmissionMarkListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AdmissionContentEvent::class => [
            AdmissionMarkListener::class,
        ],
    ];
}
