<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class CountryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "country_access" ],
            [ 'name'         => "country_list_own" ],
            [ 'name'         => "country_create" ],
            [ 'name'         => "country_edit" ],
            [ 'name'         => "country_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
