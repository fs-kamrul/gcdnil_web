<?php

namespace Modules\VenueFacility\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class KeyFacilityPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "keyfacility_access" ],
            [ 'name'         => "keyfacility_list_own" ],
            [ 'name'         => "keyfacility_list_all" ],
            [ 'name'         => "keyfacility_create" ],
            [ 'name'         => "keyfacility_edit" ],
            [ 'name'         => "keyfacility_show" ],
            [ 'name'         => "keyfacility_pdf" ],
            [ 'name'         => "keyfacility_destroy" ],
            [ 'name'         => "keyfacility_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
