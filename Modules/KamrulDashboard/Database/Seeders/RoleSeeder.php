<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'uuid' => gen_uuid(),
                'name' => "Admin",
                'is_default' => "1",
                'status' => 1,
            ],
            [
                'id' => 2,
                'uuid' => gen_uuid(),
                'name' => "User",
                'is_default' => "1",
                'status' => 1,
            ],
            [
                'id' => 3,
                'uuid' => gen_uuid(),
                'name' => "Register",
                'is_default' => "1",
                'status' => 1,
            ]
        ];

        Role::upsert($data, ['id']);
    }
}
