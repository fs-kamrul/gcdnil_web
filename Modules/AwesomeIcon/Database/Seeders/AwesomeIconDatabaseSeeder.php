<?php

namespace Modules\AwesomeIcon\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AwesomeIconDatabaseSeeder extends Seeder
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
                AwesomeIconPermissionSeeder::class,
                AwesomeIconSeeder::class,
            ]
        );
    }
}
