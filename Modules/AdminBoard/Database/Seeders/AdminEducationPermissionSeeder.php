<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminEducationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admineducation_access" ],
            [ 'name'         => "admineducation_list_own" ],
            [ 'name'         => "admineducation_list_all" ],
            [ 'name'         => "admineducation_create" ],
            [ 'name'         => "admineducation_edit" ],
            [ 'name'         => "admineducation_show" ],
            [ 'name'         => "admineducation_pdf" ],
            [ 'name'         => "admineducation_destroy" ],
            [ 'name'         => "admineducation_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
