<?php

namespace Modules\Widget\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class WidgetPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "widget_access" ],
//            [ 'name'         => "widget_list_own" ],
//            [ 'name'         => "widget_list_all" ],
//            [ 'name'         => "widget_create" ],
//            [ 'name'         => "widget_edit" ],
//            [ 'name'         => "widget_pdf" ],
//            [ 'name'         => "widget_show" ],
//            [ 'name'         => "widget_destroy" ],
//            [ 'name'         => "widget_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
