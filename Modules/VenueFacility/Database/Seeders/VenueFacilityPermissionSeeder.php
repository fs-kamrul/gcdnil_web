<?php

namespace Modules\VenueFacility\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class VenueFacilityPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "venuefacility_access" ],
            [ 'name'         => "venuefacility_list_own" ],
            [ 'name'         => "venuefacility_list_all" ],
            [ 'name'         => "venuefacility_create" ],
            [ 'name'         => "venuefacility_edit" ],
            [ 'name'         => "venuefacility_pdf" ],
            [ 'name'         => "venuefacility_show" ],
            [ 'name'         => "venuefacility_destroy" ],
            [ 'name'         => "venuefacility_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
