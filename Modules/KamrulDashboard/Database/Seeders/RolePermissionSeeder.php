<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "role_access" ],
            [ 'name'         => "role_create" ],
            [ 'name'         => "role_edit" ],
            [ 'name'         => "role_pdf" ],
            [ 'name'         => "role_show" ],
            [ 'name'         => "role_destroy" ],
            [ 'name'         => "role_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
