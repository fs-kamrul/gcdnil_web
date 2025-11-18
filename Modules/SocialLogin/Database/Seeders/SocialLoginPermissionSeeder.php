<?php

namespace Modules\SocialLogin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class SocialLoginPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "sociallogin_access" ],
        ];

        Permission::upsert($data, ['name']);
    }
}
