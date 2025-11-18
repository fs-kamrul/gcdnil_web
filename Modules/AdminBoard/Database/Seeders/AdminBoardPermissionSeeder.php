<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminBoardPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminboard_access" ],
            [ 'name'         => "adminboard_list_own" ],
            [ 'name'         => "adminboard_list_all" ],
            [ 'name'         => "adminboard_create" ],
            [ 'name'         => "adminboard_edit" ],
            [ 'name'         => "adminboard_pdf" ],
            [ 'name'         => "adminboard_show" ],
            [ 'name'         => "adminboard_destroy" ],
            [ 'name'         => "adminboard_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
