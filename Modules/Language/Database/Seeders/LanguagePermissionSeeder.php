<?php

namespace Modules\Language\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class LanguagePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "language_access" ],
            [ 'name'         => "language_list_own" ],
            [ 'name'         => "language_list_all" ],
            [ 'name'         => "language_create" ],
            [ 'name'         => "language_edit" ],
            [ 'name'         => "language_pdf" ],
            [ 'name'         => "language_show" ],
            [ 'name'         => "language_destroy" ],
            [ 'name'         => "language_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
