<?php

namespace Modules\Admission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdmissionMeritPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admissionmerit_access" ],
            [ 'name'         => "admissionmerit_list_own" ],
            [ 'name'         => "admissionmerit_list_all" ],
            [ 'name'         => "admissionmerit_create" ],
            [ 'name'         => "admissionmerit_edit" ],
            [ 'name'         => "admissionmerit_show" ],
            [ 'name'         => "admissionmerit_pdf" ],
            [ 'name'         => "admissionmerit_destroy" ],
            [ 'name'         => "admissionmerit_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
