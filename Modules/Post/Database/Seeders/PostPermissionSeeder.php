<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class PostPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "post_access" ],
            [ 'name'         => "post_create" ],
            [ 'name'         => "post_edit" ],
            [ 'name'         => "post_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
