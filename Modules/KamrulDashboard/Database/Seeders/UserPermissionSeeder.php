<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "user_access" ],
            [ 'name'         => "user_index" ],
            [ 'name'         => "user_create" ],
            [ 'name'         => "user_edit" ],
            [ 'name'         => "user_pdf" ],
            [ 'name'         => "user_show" ],
            [ 'name'         => "user_destroy" ],
            [ 'name'         => "user_import" ],
            [ 'name'         => "password_update" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
