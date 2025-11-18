<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class PermissionSeeder extends Seeder
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
            [ 'name'         => "permission_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
