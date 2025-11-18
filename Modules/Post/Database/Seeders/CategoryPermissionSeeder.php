<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class CategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "category_access" ],
            [ 'name'         => "category_list_own" ],
            [ 'name'         => "category_list_all" ],
            [ 'name'         => "category_create" ],
            [ 'name'         => "category_edit" ],
            [ 'name'         => "category_show" ],
            [ 'name'         => "category_pdf" ],
            [ 'name'         => "category_destroy" ],
            [ 'name'         => "category_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
