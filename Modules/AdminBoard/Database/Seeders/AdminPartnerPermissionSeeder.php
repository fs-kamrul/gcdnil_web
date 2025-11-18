<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminPartnerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "adminpartner_access" ],
            [ 'name'         => "adminpartner_list_own" ],
            [ 'name'         => "adminpartner_list_all" ],
            [ 'name'         => "adminpartner_create" ],
            [ 'name'         => "adminpartner_edit" ],
            [ 'name'         => "adminpartner_show" ],
            [ 'name'         => "adminpartner_pdf" ],
            [ 'name'         => "adminpartner_destroy" ],
            [ 'name'         => "adminpartner_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
