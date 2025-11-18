<?php

namespace Modules\Admission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdmissionMarkPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admissionmark_access" ],
            [ 'name'         => "admissionmark_list_own" ],
            [ 'name'         => "admissionmark_list_all" ],
            [ 'name'         => "admissionmark_create" ],
            [ 'name'         => "admissionmark_edit" ],
            [ 'name'         => "admissionmark_show" ],
            [ 'name'         => "admissionmark_pdf" ],
            [ 'name'         => "admissionmark_destroy" ],
            [ 'name'         => "admissionmark_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
