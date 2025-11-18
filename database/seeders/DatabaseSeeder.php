<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Database\Seeders\CurrencySeeder;
use Modules\KamrulDashboard\Database\Seeders\SettingSeeder;
use Modules\KamrulDashboard\Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(
            [
//                CurrencySeeder::class,
//                UserSeeder::class,
//                SettingSeeder::class,
            ]
        );
    }
}
