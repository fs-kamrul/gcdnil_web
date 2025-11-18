<?php

namespace Modules\Theme\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class ThemePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "theme_access" ],
            [ 'name'         => "theme_index" ],
            [ 'name'         => "theme_setting_access" ],
            [ 'name'         => "theme_general" ],
//            [ 'name'         => "theme_list_all" ],
            [ 'name'         => "theme_create" ],
//            [ 'name'         => "theme_edit" ],
//            [ 'name'         => "theme_pdf" ],
            [ 'name'         => "theme_show" ],
            [ 'name'         => "theme_destroy" ],
//            [ 'name'         => "theme_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
