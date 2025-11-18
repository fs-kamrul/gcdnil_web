<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminStudentGuidelinePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminstudentguideline_access" ],
            [ 'name'         => "adminstudentguideline_list_own" ],
            [ 'name'         => "adminstudentguideline_list_all" ],
            [ 'name'         => "adminstudentguideline_create" ],
            [ 'name'         => "adminstudentguideline_edit" ],
            [ 'name'         => "adminstudentguideline_show" ],
            [ 'name'         => "adminstudentguideline_pdf" ],
            [ 'name'         => "adminstudentguideline_destroy" ],
            [ 'name'         => "adminstudentguideline_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
