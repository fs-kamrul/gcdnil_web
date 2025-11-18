<?php

namespace Modules\Post\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Post\Http\Listeners\RenderingSiteMapListener;
use Modules\Theme\Events\RenderingSiteMapEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RenderingSiteMapEvent::class => [
            RenderingSiteMapListener::class,
        ],
    ];
}
