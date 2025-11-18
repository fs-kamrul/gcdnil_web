<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionSetPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionset_access" ],
            [ 'name'         => "optionset_list_own" ],
            [ 'name'         => "optionset_list_all" ],
            [ 'name'         => "optionset_create" ],
            [ 'name'         => "optionset_edit" ],
            [ 'name'         => "optionset_show" ],
            [ 'name'         => "optionset_pdf" ],
            [ 'name'         => "optionset_destroy" ],
            [ 'name'         => "optionset_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
