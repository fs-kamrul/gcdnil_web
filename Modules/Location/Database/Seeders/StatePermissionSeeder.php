<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class StatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "state_access" ],
            [ 'name'         => "state_list_own" ],
            [ 'name'         => "state_create" ],
            [ 'name'         => "state_edit" ],
            [ 'name'         => "state_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
