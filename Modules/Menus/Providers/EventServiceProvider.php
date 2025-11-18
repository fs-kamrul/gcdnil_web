<?php

namespace Modules\Menus\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedSlugEvent;
use Modules\Menu\Listeners\UpdateMenuNodeUrlListener;
use Modules\Menus\Listeners\DeleteMenuNodeListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedSlugEvent::class => [
            UpdateMenuNodeUrlListener::class,
        ],
        DeletedContentEvent::class => [
            DeleteMenuNodeListener::class,
        ],
    ];
}
