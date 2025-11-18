<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminClubPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminclub_access" ],
            [ 'name'         => "adminclub_list_own" ],
            [ 'name'         => "adminclub_list_all" ],
            [ 'name'         => "adminclub_create" ],
            [ 'name'         => "adminclub_edit" ],
            [ 'name'         => "adminclub_show" ],
            [ 'name'         => "adminclub_pdf" ],
            [ 'name'         => "adminclub_destroy" ],
            [ 'name'         => "adminclub_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
