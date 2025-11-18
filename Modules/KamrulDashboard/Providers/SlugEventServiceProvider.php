<?php

namespace Modules\KamrulDashboard\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Listeners\SlugCreatedContentListener;
use Modules\KamrulDashboard\Listeners\SlugDeletedContentListener;
use Modules\KamrulDashboard\Listeners\SlugUpdatedContentListener;

class SlugEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UpdatedContentEvent::class => [
            SlugUpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            SlugCreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            SlugDeletedContentListener::class,
        ],
    ];
}
