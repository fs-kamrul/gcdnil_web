<?php

namespace Modules\ContactForm\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class ContactFormPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "contactform_access" ],
//            [ 'name'         => "contactform_list_own" ],
            [ 'name'         => "contactform_list_all" ],
//            [ 'name'         => "contactform_create" ],
            [ 'name'         => "contactform_edit" ],
            [ 'name'         => "contactform_pdf" ],
            [ 'name'         => "contactform_show" ],
            [ 'name'         => "contactform_destroy" ],
//            [ 'name'         => "contactform_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
