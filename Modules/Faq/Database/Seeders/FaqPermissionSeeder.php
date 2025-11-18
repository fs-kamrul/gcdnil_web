<?php

namespace Modules\Faq\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class FaqPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "faq_access" ],
            [ 'name'         => "faq_create" ],
            [ 'name'         => "faq_edit" ],
            [ 'name'         => "faq_destroy" ],
        ];

        Permission::upsert($data, ['name']);
    }
}
