<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class AdminTestimonialPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "admintestimonial_access" ],
            [ 'name'         => "admintestimonial_list_own" ],
            [ 'name'         => "admintestimonial_list_all" ],
            [ 'name'         => "admintestimonial_create" ],
            [ 'name'         => "admintestimonial_edit" ],
            [ 'name'         => "admintestimonial_show" ],
            [ 'name'         => "admintestimonial_pdf" ],
            [ 'name'         => "admintestimonial_destroy" ],
            [ 'name'         => "admintestimonial_import" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
