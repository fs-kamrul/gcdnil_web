<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminFacilityPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminfacility_access" ],
            [ 'name'         => "adminfacility_list_own" ],
            [ 'name'         => "adminfacility_list_all" ],
            [ 'name'         => "adminfacility_create" ],
            [ 'name'         => "adminfacility_edit" ],
            [ 'name'         => "adminfacility_show" ],
            [ 'name'         => "adminfacility_pdf" ],
            [ 'name'         => "adminfacility_destroy" ],
            [ 'name'         => "adminfacility_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
