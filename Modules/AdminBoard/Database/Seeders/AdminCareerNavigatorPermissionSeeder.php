<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminCareerNavigatorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admincareernavigator_access" ],
            [ 'name'         => "admincareernavigator_list_own" ],
            [ 'name'         => "admincareernavigator_list_all" ],
            [ 'name'         => "admincareernavigator_create" ],
            [ 'name'         => "admincareernavigator_edit" ],
            [ 'name'         => "admincareernavigator_show" ],
            [ 'name'         => "admincareernavigator_pdf" ],
            [ 'name'         => "admincareernavigator_destroy" ],
            [ 'name'         => "admincareernavigator_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
