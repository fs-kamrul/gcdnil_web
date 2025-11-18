<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminEventPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminevent_access" ],
            [ 'name'         => "adminevent_list_own" ],
            [ 'name'         => "adminevent_list_all" ],
            [ 'name'         => "adminevent_create" ],
            [ 'name'         => "adminevent_edit" ],
            [ 'name'         => "adminevent_show" ],
            [ 'name'         => "adminevent_pdf" ],
            [ 'name'         => "adminevent_destroy" ],
            [ 'name'         => "adminevent_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
