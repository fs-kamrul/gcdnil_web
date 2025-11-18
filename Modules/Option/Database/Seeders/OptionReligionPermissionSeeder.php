<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionReligionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionreligion_access" ],
            [ 'name'         => "optionreligion_list_own" ],
            [ 'name'         => "optionreligion_list_all" ],
            [ 'name'         => "optionreligion_create" ],
            [ 'name'         => "optionreligion_edit" ],
            [ 'name'         => "optionreligion_show" ],
            [ 'name'         => "optionreligion_pdf" ],
            [ 'name'         => "optionreligion_destroy" ],
            [ 'name'         => "optionreligion_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
