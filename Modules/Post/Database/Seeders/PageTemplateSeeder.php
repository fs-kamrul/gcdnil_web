<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Post\Http\Models\PageTemplate;

class PageTemplateSeeder extends Seeder
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
                'id'            => 1,
                'uuid'          => gen_uuid(),
                'name'          => "Default",
                'slug'          => "default",
                'description'   => "Default",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 2,
                'uuid'          => gen_uuid(),
                'name'          => "Page",
                'slug'          => "page",
                'description'   => "Page",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 3,
                'uuid'          => gen_uuid(),
                'name'          => "Homepage",
                'slug'          => "homepage",
                'description'   => "Homepage",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 4,
                'uuid'          => gen_uuid(),
                'name'          => "Right sidebar",
                'slug'          => "right-sidebar",
                'description'   => "Right sidebar",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 5,
                'uuid'          => gen_uuid(),
                'name'          => "Full width",
                'slug'          => "full-width",
                'description'   => "Full width",
                'status'        => 1,
                'user_id'       => 1,
            ],
        ];

        PageTemplate::upsert($data, ['name']);
    }
}
