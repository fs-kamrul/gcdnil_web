<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminCategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admincategory_access" ],
            [ 'name'         => "admincategory_list_own" ],
            [ 'name'         => "admincategory_list_all" ],
            [ 'name'         => "admincategory_create" ],
            [ 'name'         => "admincategory_edit" ],
            [ 'name'         => "admincategory_show" ],
            [ 'name'         => "admincategory_pdf" ],
            [ 'name'         => "admincategory_destroy" ],
            [ 'name'         => "admincategory_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
