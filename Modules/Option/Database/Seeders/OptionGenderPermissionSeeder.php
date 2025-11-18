<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionGenderPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optiongender_access" ],
            [ 'name'         => "optiongender_list_own" ],
            [ 'name'         => "optiongender_list_all" ],
            [ 'name'         => "optiongender_create" ],
            [ 'name'         => "optiongender_edit" ],
            [ 'name'         => "optiongender_show" ],
            [ 'name'         => "optiongender_pdf" ],
            [ 'name'         => "optiongender_destroy" ],
            [ 'name'         => "optiongender_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
