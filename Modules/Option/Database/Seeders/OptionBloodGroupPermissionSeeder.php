<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionBloodGroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionbloodgroup_access" ],
            [ 'name'         => "optionbloodgroup_list_own" ],
            [ 'name'         => "optionbloodgroup_list_all" ],
            [ 'name'         => "optionbloodgroup_create" ],
            [ 'name'         => "optionbloodgroup_edit" ],
            [ 'name'         => "optionbloodgroup_show" ],
            [ 'name'         => "optionbloodgroup_pdf" ],
            [ 'name'         => "optionbloodgroup_destroy" ],
            [ 'name'         => "optionbloodgroup_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
