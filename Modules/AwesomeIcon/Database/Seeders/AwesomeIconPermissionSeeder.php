<?php

namespace Modules\AwesomeIcon\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AwesomeIconPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "awesomeicon_access" ],
            [ 'name'         => "awesomeicon_list_own" ],
            [ 'name'         => "awesomeicon_list_all" ],
            [ 'name'         => "awesomeicon_create" ],
            [ 'name'         => "awesomeicon_edit" ],
            [ 'name'         => "awesomeicon_pdf" ],
            [ 'name'         => "awesomeicon_show" ],
            [ 'name'         => "awesomeicon_destroy" ],
            [ 'name'         => "awesomeicon_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
