<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OptionDatabaseSeeder extends Seeder
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
                OptionPermissionSeeder::class,
                OptionBloodGroupPermissionSeeder::class,
                OptionSetPermissionSeeder::class,
                OptionClassPermissionSeeder::class,
                OptionSubjectPermissionSeeder::class,
                OptionGenderPermissionSeeder::class,
                OptionReligionPermissionSeeder::class,
                OptionSectionPermissionSeeder::class,
                OptionGroupPermissionSeeder::class,
                OptionYearPermissionSeeder::class,

                OptionClassSeeder::class,
                OptionGenderSeeder::class,
                OptionReligionSeeder::class,
                OptionSectionSeeder::class,
                OptionGroupSeeder::class,
                OptionYearSeeder::class,
                OptionSubjectSeeder::class,
                OptionBloodGroupSeeder::class,

            ]
        );
    }
}

