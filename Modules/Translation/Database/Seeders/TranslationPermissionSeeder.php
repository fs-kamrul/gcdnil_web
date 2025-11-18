<?php

namespace Modules\Translation\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class TranslationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "translation_access" ],
            [ 'name'         => "translation_locales_access" ],
            [ 'name'         => "translation_theme_translations" ],
            [ 'name'         => "translation_admin_translations" ],
            [ 'name'         => "translation_create" ],
            [ 'name'         => "translation_edit" ],
            [ 'name'         => "translation_destroy" ],
            [ 'name'         => "translation_index" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
