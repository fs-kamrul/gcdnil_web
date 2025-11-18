<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class SettingsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "settings_access" ],
            [ 'name'         => "settings_create" ],
            [ 'name'         => "settings_edit" ],
            [ 'name'         => "settings_show" ],
            [ 'name'         => "settings_sub_add" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
