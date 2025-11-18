<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminWorkshopPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminworkshop_access" ],
            [ 'name'         => "adminworkshop_list_own" ],
            [ 'name'         => "adminworkshop_list_all" ],
            [ 'name'         => "adminworkshop_create" ],
            [ 'name'         => "adminworkshop_edit" ],
            [ 'name'         => "adminworkshop_show" ],
            [ 'name'         => "adminworkshop_pdf" ],
            [ 'name'         => "adminworkshop_destroy" ],
            [ 'name'         => "adminworkshop_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
