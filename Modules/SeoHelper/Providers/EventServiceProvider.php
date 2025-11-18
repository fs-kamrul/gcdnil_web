<?php

namespace Modules\SeoHelper\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\SeoHelper\Listeners\CreatedContentListener;
use Modules\SeoHelper\Listeners\DeletedContentListener;
use Modules\SeoHelper\Listeners\UpdatedContentListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
    ];
}
