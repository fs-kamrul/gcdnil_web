<?php

namespace Modules\Theme\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Routing\Router;
use Modules\KamrulDashboard\Events\Event;

class ThemeRoutingBeforeEvent extends Event
{
    use SerializesModels;

    /**
     * @var Router
     */
    public $router;

    public function __construct()
    {
        $this->router = app('router');
    }
}
