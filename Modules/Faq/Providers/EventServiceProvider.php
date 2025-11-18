<?php

namespace Modules\Faq\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Faq\Listeners\CreatedContentListener;
use Modules\Faq\Listeners\DeletedContentListener;
use Modules\Faq\Listeners\UpdatedContentListener;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;

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
