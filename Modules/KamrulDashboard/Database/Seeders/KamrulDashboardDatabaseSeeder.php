<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class KamrulDashboardDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(
            [
                KamrulDashboardPermissionSeeder::class,
                RolePermissionSeeder::class,
                RoleSeeder::class,
                UserPermissionSeeder::class,
                PermissionPermissionSeeder::class,
                SystemsPermissionSeeder::class,
                BackupPermissionSeeder::class,
                SettingsPermissionSeeder::class,
//                CurrencySeeder::class,
                UserSeeder::class,
                SettingSeeder::class,
                PermissionSeeder::class,
                SettingDataSeeder::class,
            ]
        );
    }
}



