<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class PostTypePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "posttype_access" ],
            [ 'name'         => "posttype_list_own" ],
            [ 'name'         => "posttype_list_all" ],
//            [ 'name'         => "posttype_create" ],
//            [ 'name'         => "posttype_edit" ],
            [ 'name'         => "posttype_show" ],
            [ 'name'         => "posttype_pdf" ],
//            [ 'name'         => "posttype_destroy" ],
//            [ 'name'         => "posttype_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
