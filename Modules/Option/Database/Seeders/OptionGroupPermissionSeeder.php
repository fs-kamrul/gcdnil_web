<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionGroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optiongroup_access" ],
            [ 'name'         => "optiongroup_list_own" ],
            [ 'name'         => "optiongroup_list_all" ],
            [ 'name'         => "optiongroup_create" ],
            [ 'name'         => "optiongroup_edit" ],
            [ 'name'         => "optiongroup_show" ],
            [ 'name'         => "optiongroup_pdf" ],
            [ 'name'         => "optiongroup_destroy" ],
            [ 'name'         => "optiongroup_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
