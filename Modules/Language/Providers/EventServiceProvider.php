<?php

namespace Modules\Language\Providers;

use Modules\KamrulDashboard\Events\ActivatedPluginEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\Language\Listeners\ActivatedPluginListener;
use Modules\Language\Listeners\AddHrefLangListener;
use Modules\Language\Listeners\CreatedContentListener;
use Modules\Language\Listeners\DeletedContentListener;
use Modules\Language\Listeners\ThemeRemoveListener;
use Modules\Language\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Theme\Events\RenderingSingleEvent;
use Modules\Theme\Events\ThemeRemoveEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UpdatedContentEvent::class  => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class  => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class  => [
            DeletedContentListener::class,
        ],
        ThemeRemoveEvent::class     => [
            ThemeRemoveListener::class,
        ],
        ActivatedPluginEvent::class => [
            ActivatedPluginListener::class,
        ],
        RenderingSingleEvent::class => [
            AddHrefLangListener::class,
        ],
    ];
}
