<?php

namespace Modules\ThemeIcon\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class ThemeIconPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "themeicon_access" ],
            [ 'name'         => "themeicon_list_own" ],
            [ 'name'         => "themeicon_list_all" ],
            [ 'name'         => "themeicon_create" ],
            [ 'name'         => "themeicon_edit" ],
            [ 'name'         => "themeicon_pdf" ],
            [ 'name'         => "themeicon_show" ],
            [ 'name'         => "themeicon_destroy" ],
            [ 'name'         => "themeicon_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
