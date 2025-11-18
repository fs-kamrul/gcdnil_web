<?php

namespace Modules\ThemeIcon\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ThemeIconDatabaseSeeder extends Seeder
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
                ThemeIconPermissionSeeder::class,
                ThemeIconSeeder::class,
            ]
        );
    }
}
