<?php

namespace Modules\Admission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdmissionSubjectPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admissionsubject_access" ],
            [ 'name'         => "admissionsubject_list_own" ],
            [ 'name'         => "admissionsubject_list_all" ],
            [ 'name'         => "admissionsubject_create" ],
            [ 'name'         => "admissionsubject_edit" ],
            [ 'name'         => "admissionsubject_show" ],
            [ 'name'         => "admissionsubject_pdf" ],
            [ 'name'         => "admissionsubject_destroy" ],
            [ 'name'         => "admissionsubject_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
