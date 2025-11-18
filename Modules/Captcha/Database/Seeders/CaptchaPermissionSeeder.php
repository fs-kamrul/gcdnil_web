<?php

namespace Modules\Captcha\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class CaptchaPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "captcha_access" ],
            [ 'name'         => "captcha_create" ],
            [ 'name'         => "captcha_edit" ],
            [ 'name'         => "captcha_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
