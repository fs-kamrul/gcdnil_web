<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class KamrulDashboardPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "kamruldashboard_access" ],
            [ 'name'         => "manage_plugins_index" ],
//            [ 'name'         => "kamruldashboard_create" ],
//            [ 'name'         => "kamruldashboard_edit" ],
//            [ 'name'         => "kamruldashboard_pdf" ],
//            [ 'name'         => "kamruldashboard_show" ],
//            [ 'name'         => "kamruldashboard_destroy" ],
//            [ 'name'         => "kamruldashboard_import" ],
            [ 'name'         => "manage_plugins" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
