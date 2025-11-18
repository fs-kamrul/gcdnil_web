<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "option_access" ],
            [ 'name'         => "option_list_own" ],
            [ 'name'         => "option_list_all" ],
            [ 'name'         => "option_create" ],
            [ 'name'         => "option_edit" ],
            [ 'name'         => "option_pdf" ],
            [ 'name'         => "option_show" ],
            [ 'name'         => "option_destroy" ],
            [ 'name'         => "option_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
