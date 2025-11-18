<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionSectionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionsection_access" ],
            [ 'name'         => "optionsection_list_own" ],
            [ 'name'         => "optionsection_list_all" ],
            [ 'name'         => "optionsection_create" ],
            [ 'name'         => "optionsection_edit" ],
            [ 'name'         => "optionsection_show" ],
            [ 'name'         => "optionsection_pdf" ],
            [ 'name'         => "optionsection_destroy" ],
            [ 'name'         => "optionsection_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
