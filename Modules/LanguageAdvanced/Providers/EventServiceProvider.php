<?php

namespace Modules\LanguageAdvanced\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\KamrulDashboard\Events\ActivatedPluginEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\LanguageAdvanced\Listeners\AddDefaultTranslations;
use Modules\LanguageAdvanced\Listeners\DeletedContentListener;
use Modules\LanguageAdvanced\Listeners\PriorityLanguageAdvancedPluginListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DeletedContentEvent::class  => [
            DeletedContentListener::class,
        ],
        CreatedContentEvent::class  => [
            AddDefaultTranslations::class,
        ],
        ActivatedPluginEvent::class => [
            PriorityLanguageAdvancedPluginListener::class,
        ],
    ];
}
