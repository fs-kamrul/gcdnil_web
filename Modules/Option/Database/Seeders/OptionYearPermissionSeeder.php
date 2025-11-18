<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionYearPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionyear_access" ],
            [ 'name'         => "optionyear_list_own" ],
            [ 'name'         => "optionyear_list_all" ],
            [ 'name'         => "optionyear_create" ],
            [ 'name'         => "optionyear_edit" ],
            [ 'name'         => "optionyear_show" ],
            [ 'name'         => "optionyear_pdf" ],
            [ 'name'         => "optionyear_destroy" ],
            [ 'name'         => "optionyear_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
