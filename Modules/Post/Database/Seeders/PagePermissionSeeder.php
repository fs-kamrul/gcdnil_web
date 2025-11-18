<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class PagePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "page_access" ],
            [ 'name'         => "page_index" ],
            [ 'name'         => "page_create" ],
            [ 'name'         => "page_edit" ],
            [ 'name'         => "page_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
