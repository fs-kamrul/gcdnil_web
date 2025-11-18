<?php

namespace Modules\Menus\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class MenusPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "menus_access" ],
            [ 'name'         => "menus_list_own" ],
            [ 'name'         => "menus_list_all" ],
            [ 'name'         => "menus_create" ],
            [ 'name'         => "menus_edit" ],
            [ 'name'         => "menus_pdf" ],
            [ 'name'         => "menus_show" ],
            [ 'name'         => "menus_destroy" ],
            [ 'name'         => "menus_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
