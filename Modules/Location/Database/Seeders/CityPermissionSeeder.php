<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class CityPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "city_access" ],
            [ 'name'         => "city_list_own" ],
            [ 'name'         => "city_create" ],
            [ 'name'         => "city_edit" ],
            [ 'name'         => "city_destroy" ],
        ];

        Permission::upsert($data, ['name']);
    }
}
