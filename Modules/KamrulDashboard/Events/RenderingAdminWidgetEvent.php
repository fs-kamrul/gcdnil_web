<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\KamrulDashboard\Widgets\Contracts\AdminWidget;

class RenderingAdminWidgetEvent
{
    use Dispatchable;

    public $widget;

    public function __construct(AdminWidget $widget)
    {
        $this->widget = $widget;
    }
}
