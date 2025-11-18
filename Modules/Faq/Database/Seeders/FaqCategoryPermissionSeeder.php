<?php

namespace Modules\Faq\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class FaqCategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "faqcategory_access" ],
            [ 'name'         => "faqcategory_create" ],
            [ 'name'         => "faqcategory_edit" ],
            [ 'name'         => "faqcategory_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
