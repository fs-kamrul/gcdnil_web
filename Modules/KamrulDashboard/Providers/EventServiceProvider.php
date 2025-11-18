<?php

namespace Modules\KamrulDashboard\Providers;

use Illuminate\Support\Facades\Event;
use File;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\SendMailEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Listeners\BeforeEditContentListener;
use Modules\KamrulDashboard\Listeners\CreatedContentListener;
use Modules\KamrulDashboard\Listeners\DeletedContentListener;
use Modules\KamrulDashboard\Listeners\SendMailListener;
use Modules\KamrulDashboard\Listeners\UpdatedContentListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SendMailEvent::class          => [
            SendMailListener::class,
        ],
        CreatedContentEvent::class    => [
            CreatedContentListener::class,
        ],
        UpdatedContentEvent::class    => [
            UpdatedContentListener::class,
        ],
        DeletedContentEvent::class    => [
            DeletedContentListener::class,
        ],
        BeforeEditContentEvent::class => [
            BeforeEditContentListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        Event::listen(['cache:cleared'], function () {
            File::delete([storage_path('cache_keys.json'), storage_path('settings.json')]);
        });
    }
}
