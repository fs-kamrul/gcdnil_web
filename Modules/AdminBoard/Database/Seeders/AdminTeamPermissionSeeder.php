<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminTeamPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminteam_access" ],
            [ 'name'         => "adminteam_list_own" ],
            [ 'name'         => "adminteam_list_all" ],
            [ 'name'         => "adminteam_create" ],
            [ 'name'         => "adminteam_edit" ],
            [ 'name'         => "adminteam_show" ],
            [ 'name'         => "adminteam_pdf" ],
            [ 'name'         => "adminteam_destroy" ],
            [ 'name'         => "adminteam_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
