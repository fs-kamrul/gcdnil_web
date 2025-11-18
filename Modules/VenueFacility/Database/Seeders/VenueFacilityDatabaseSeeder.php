<?php

namespace Modules\VenueFacility\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class VenueFacilityDatabaseSeeder extends Seeder
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
                VenueFacilityPermissionSeeder::class,
                KeyFacilityPermissionSeeder::class,

            ]
        );
    }
}

