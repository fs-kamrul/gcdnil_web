<?php

namespace Modules\Analytics\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AnalyticsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "analytics_access" ],
            [ 'name'         => "analytics_index" ],
            [ 'name'         => "analytics_referrer" ],
            [ 'name'         => "analytics_browser" ],
            [ 'name'         => "analytics_page" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
