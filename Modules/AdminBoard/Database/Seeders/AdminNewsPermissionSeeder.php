<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminNewsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminnews_access" ],
            [ 'name'         => "adminnews_list_own" ],
            [ 'name'         => "adminnews_list_all" ],
            [ 'name'         => "adminnews_create" ],
            [ 'name'         => "adminnews_edit" ],
            [ 'name'         => "adminnews_show" ],
            [ 'name'         => "adminnews_pdf" ],
            [ 'name'         => "adminnews_destroy" ],
            [ 'name'         => "adminnews_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
