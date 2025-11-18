<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class PermissionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "permission_access" ],
            [ 'name'         => "permission_create" ],
            [ 'name'         => "permission_edit" ],
            [ 'name'         => "permission_pdf" ],
            [ 'name'         => "permission_show" ],
            [ 'name'         => "permission_destroy" ],
//            [ 'name'         => "permission_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
