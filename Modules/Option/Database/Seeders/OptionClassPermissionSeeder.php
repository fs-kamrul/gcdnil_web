<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionClassPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionclass_access" ],
            [ 'name'         => "optionclass_list_own" ],
            [ 'name'         => "optionclass_list_all" ],
            [ 'name'         => "optionclass_create" ],
            [ 'name'         => "optionclass_edit" ],
            [ 'name'         => "optionclass_show" ],
            [ 'name'         => "optionclass_pdf" ],
            [ 'name'         => "optionclass_destroy" ],
            [ 'name'         => "optionclass_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
