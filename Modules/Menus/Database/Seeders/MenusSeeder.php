<?php

namespace Modules\Menus\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Menus\Http\Models\Menus;
use Modules\Menus\Http\Models\MenusLocation;

class MenusSeeder extends Seeder
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
                'id'                => 1,
                'uuid'              => gen_uuid(),
                'name'              => "Main Menu",
                'slug'              => "main-menu",
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => 2,
                'uuid'              => gen_uuid(),
                'name'              => "Header menu",
                'slug'              => "header-menu",
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => 3,
                'uuid'              => gen_uuid(),
                'name'              => "Footer menu",
                'slug'              => "footer-menu",
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => 4,
                'uuid'              => gen_uuid(),
                'name'              => "Quick menu",
                'slug'              => "quick-menu",
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => 5,
                'uuid'              => gen_uuid(),
                'name'              => "Footer 1",
                'slug'              => "footer1",
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => 6,
                'uuid'              => gen_uuid(),
                'name'              => "Footer 2",
                'slug'              => "footer2",
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => 7,
                'uuid'              => gen_uuid(),
                'name'              => "Footer 3",
                'slug'              => "footer3",
                'status'            => 1,
                'user_id'           => 1,
            ]
        ];
        //apply_online
        //important_links
        //bi bi-arrow-right-short
        $data_locations = [
            [
                'id'                => 1,
                'menus_id'          => 1,
                'location'          => "main-menu",
            ],
            [
                'id'                => 2,
                'menus_id'          => 2,
                'location'          => "header-menu",
            ],
            [
                'id'                => 3,
                'menus_id'          => 3,
                'location'          => "footer-menu",
            ],
        ];

        Menus::upsert($data, ['name']);
        MenusLocation::upsert($data_locations, ['location']);
    }
}
