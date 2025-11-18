<?php

namespace Modules\Analytics\Packages\Supports;

use Exception;
use Modules\KamrulDashboard\Http\Models\DashboardWidget;
use Modules\KamrulDashboard\Packages\Supports\PluginOperationAbstract;
use Modules\KamrulDashboard\Repositories\Interfaces\DashboardWidgetInterface;

class Plugin extends PluginOperationAbstract
{
    /**
     * @throws Exception
     */
    public static function remove()
    {
        $widgets = app(DashboardWidgetInterface::class)
            ->advancedGet([
                'condition' => [
                    [
                        'name',
                        'IN',
                        [
                            'widget_analytics_general',
                            'widget_analytics_page',
                            'widget_analytics_browser',
                            'widget_analytics_referrer',
                        ],
                    ],
                ],
            ]);

        foreach ($widgets as $widget) {
            /**
             * @var DashboardWidget $widget
             */
            $widget->delete();
        }
    }
}
