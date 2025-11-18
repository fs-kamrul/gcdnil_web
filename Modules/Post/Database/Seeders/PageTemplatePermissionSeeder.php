<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class PageTemplatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "pagetemplate_access" ],
            [ 'name'         => "pagetemplate_list_own" ],
            [ 'name'         => "pagetemplate_list_all" ],
//            [ 'name'         => "pagetemplate_create" ],
//            [ 'name'         => "pagetemplate_edit" ],
            [ 'name'         => "pagetemplate_show" ],
            [ 'name'         => "pagetemplate_pdf" ],
//            [ 'name'         => "pagetemplate_destroy" ],
//            [ 'name'         => "pagetemplate_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
