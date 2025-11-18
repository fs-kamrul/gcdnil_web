<?php

namespace Modules\SimpleSlider\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SimpleSliderDatabaseSeeder extends Seeder
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
                SimpleSliderPermissionSeeder::class,
            ]
        );
    }
}
