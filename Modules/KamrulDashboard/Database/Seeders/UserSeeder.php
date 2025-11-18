<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\User;
use function now;

class UserSeeder extends Seeder
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
                'username' => "kamrul",
                'name' => "kamrul islam",
                'email' => "kamrul@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$M2Yoc5bfSKMISK3e5EqI5uMscX/sS/3N/4KI1X95nzpij4M5cOt1K', // password: 12345678
                'is_admin' => 1,
                'role_id' => 1,
                'remember_token' => Str::random(10),
            ],
            [
                'id' => 2,
                'username' => "kkr",
                'name' => "kkr islam",
                'email' => "kkr@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$M2Yoc5bfSKMISK3e5EqI5uMscX/sS/3N/4KI1X95nzpij4M5cOt1K', // password: 12345678
                'is_admin' => 0,
                'role_id' => 2,
                'remember_token' => Str::random(10),
            ]
        ];

//        User::insert($data);
        User::upsert($data, ['email']);
    }
}
