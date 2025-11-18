<?php

namespace Modules\Admission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdmissionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admission_access" ],
            [ 'name'         => "admission_list_own" ],
            [ 'name'         => "admission_list_all" ],
            [ 'name'         => "admission_create" ],
            [ 'name'         => "admission_edit" ],
            [ 'name'         => "admission_pdf" ],
            [ 'name'         => "admission_show" ],
            [ 'name'         => "admission_destroy" ],
            [ 'name'         => "admission_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
