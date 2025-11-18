<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminAcademicGroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminacademicgroup_access" ],
            [ 'name'         => "adminacademicgroup_list_own" ],
            [ 'name'         => "adminacademicgroup_list_all" ],
            [ 'name'         => "adminacademicgroup_create" ],
            [ 'name'         => "adminacademicgroup_edit" ],
            [ 'name'         => "adminacademicgroup_show" ],
            [ 'name'         => "adminacademicgroup_pdf" ],
            [ 'name'         => "adminacademicgroup_destroy" ],
            [ 'name'         => "adminacademicgroup_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
