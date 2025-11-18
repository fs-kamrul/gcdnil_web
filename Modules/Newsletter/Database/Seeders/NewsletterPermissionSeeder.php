<?php

namespace Modules\Newsletter\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class NewsletterPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "newsletter_access" ],
            [ 'name'         => "newsletter_list_own" ],
            [ 'name'         => "newsletter_list_all" ],
//            [ 'name'         => "newsletter_create" ],
//            [ 'name'         => "newsletter_edit" ],
//            [ 'name'         => "newsletter_pdf" ],
//            [ 'name'         => "newsletter_show" ],
            [ 'name'         => "newsletter_destroy" ],
//            [ 'name'         => "newsletter_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
