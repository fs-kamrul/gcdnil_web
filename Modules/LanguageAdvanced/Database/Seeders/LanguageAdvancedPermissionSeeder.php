<?php

namespace Modules\LanguageAdvanced\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class LanguageAdvancedPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "languageadvanced_access" ],
            [ 'name'         => "languageadvanced_list_own" ],
            [ 'name'         => "languageadvanced_list_all" ],
            [ 'name'         => "languageadvanced_create" ],
            [ 'name'         => "languageadvanced_edit" ],
            [ 'name'         => "languageadvanced_pdf" ],
            [ 'name'         => "languageadvanced_show" ],
            [ 'name'         => "languageadvanced_destroy" ],
            [ 'name'         => "languageadvanced_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
