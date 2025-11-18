<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminNoticeBoardPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminnoticeboard_access" ],
            [ 'name'         => "adminnoticeboard_list_own" ],
            [ 'name'         => "adminnoticeboard_list_all" ],
            [ 'name'         => "adminnoticeboard_create" ],
            [ 'name'         => "adminnoticeboard_edit" ],
            [ 'name'         => "adminnoticeboard_show" ],
            [ 'name'         => "adminnoticeboard_pdf" ],
            [ 'name'         => "adminnoticeboard_destroy" ],
            [ 'name'         => "adminnoticeboard_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
