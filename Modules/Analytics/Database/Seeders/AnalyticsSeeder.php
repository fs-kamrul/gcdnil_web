<?php

namespace Modules\Analytics\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\DashboardWidget;

class AnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 1;
        $data = [
            [
                'id'            => $id++,
                'name'          => "widget_total_themes"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_total_users"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_total_pages"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_total_plugins"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_analytics_general"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_analytics_page"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_analytics_browser"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_posts_recent"
            ],
            [
                'id'            => $id++,
                'name'          => "widget_analytics_referrer"
            ],
//            [
//                'id'            => $id++,
//                'name'          => "widget_audit_logs"
//            ],
        ];

        DashboardWidget::upsert($data, ['name']);
    }
}
