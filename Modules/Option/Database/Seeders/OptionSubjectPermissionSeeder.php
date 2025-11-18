<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class OptionSubjectPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "optionsubject_access" ],
            [ 'name'         => "optionsubject_list_own" ],
            [ 'name'         => "optionsubject_list_all" ],
            [ 'name'         => "optionsubject_create" ],
            [ 'name'         => "optionsubject_edit" ],
            [ 'name'         => "optionsubject_show" ],
            [ 'name'         => "optionsubject_pdf" ],
            [ 'name'         => "optionsubject_destroy" ],
            [ 'name'         => "optionsubject_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
