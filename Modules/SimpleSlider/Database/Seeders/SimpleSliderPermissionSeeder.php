<?php

namespace Modules\SimpleSlider\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class SimpleSliderPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "simple-slider_access" ],
            [ 'name'         => "simple-slider_create" ],
            [ 'name'         => "simple-slider_edit" ],
            [ 'name'         => "simple-slider_destroy" ],
            [ 'name'         => "simple-slideritem_access" ],
            [ 'name'         => "simple-slideritem_create" ],
            [ 'name'         => "simple-slideritem_edit" ],
            [ 'name'         => "simple-slideritem_destroy" ]
        ];

        Permission::upsert($data, ['name']);
    }
}
