<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminGalleryBoardPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *ffff
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admingalleryboard_access" ],
            [ 'name'         => "admingalleryboard_list_own" ],
            [ 'name'         => "admingalleryboard_list_all" ],
            [ 'name'         => "admingalleryboard_create" ],
            [ 'name'         => "admingalleryboard_edit" ],
            [ 'name'         => "admingalleryboard_show" ],
            [ 'name'         => "admingalleryboard_pdf" ],
            [ 'name'         => "admingalleryboard_destroy" ],
            [ 'name'         => "admingalleryboard_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
