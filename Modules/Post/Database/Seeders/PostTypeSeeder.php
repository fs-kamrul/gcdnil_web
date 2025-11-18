<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\PostType;

class PostTypeSeeder extends Seeder
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
                'name'          => "None",
                'description'   => "none",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 2,
                'uuid'          => gen_uuid(),
                'name'          => "Our Team",
                'description'   => "Our Team",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 3,
                'uuid'          => gen_uuid(),
                'name'          => "About Us",
                'description'   => "About Us",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 4,
                'uuid'          => gen_uuid(),
                'name'          => 'Our Services',
                'description'   => 'Our Services',
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 5,
                'uuid'          => gen_uuid(),
                'name'          => "News",
                'description'   => "News",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 6,
                'uuid'          => gen_uuid(),
                'name'          => "Testimonial",
                'description'   => "Testimonial",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 7,
                'uuid'          => gen_uuid(),
                'name'          => "Training",
                'description'   => "Training",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 8,
                'uuid'          => gen_uuid(),
                'name'          => "Workshop",
                'description'   => "Workshop",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => 9,
                'uuid'          => gen_uuid(),
                'name'          => "Our Feature",
                'description'   => "Our Feature",
                'status'        => 1,
                'user_id'       => 1,
            ],
        ];

        PostType::upsert($data, ['name']);
    }
}
