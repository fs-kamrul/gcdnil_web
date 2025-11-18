<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\Menus\Http\Models\MenusNode;
use Modules\Post\Http\Models\Category;
use SlugHelper;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 1;
        $data = [
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "Uncategorized",
                'parent_id'     => "0",
                'description'   => "Uncategorized",
                'photo'         => "",
                'slug'          => "uncategorized",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "Admission",
                'parent_id'     => "0",
                'description'   => "Admission",
                'photo'         => "admission.jpg",
                'slug'          => "admission",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "Academic Sections",
                'parent_id'     => "0",
                'description'   => "Academic Sections. Everyday Care for your Children.",
                'photo'         => "academics.png",
                'slug'          => "academic-sections",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "Facilities",
                'parent_id'     => "0",
                'description'   => "Facilities",
                'photo'         => "facilities.png",
                'slug'          => "facilities",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "News & Events",
                'parent_id'     => "0",
                'description'   => "Why we are the best.",
                'photo'         => "",
                'slug'          => "news-events",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "Home Gallery",
                'parent_id'     => "0",
                'description'   => "Home Gallery",
                'photo'         => "",
                'slug'          => "home-gallery",
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'name'          => "Courses",
                'parent_id'     => "0",
                'description'   => "Courses",
                'photo'         => "",
                'slug'          => "courses",
                'status'        => 1,
                'user_id'       => 1,
            ],
        ];
        $post_slug = array();
        foreach ($data as $key=>$value){
            $data_set = [
                'id'                => $key+1,
                'key'               => $value['slug'],
                'reference_id'      => $value['id'],
                'reference_type'    => Category::class,
                'prefix'            => SlugHelper::getPrefix(Category::class),
            ];
            array_push($post_slug,$data_set);
        }
        Category::upsert($data, ['name']);
        Slug::upsert($post_slug, ['key']);
    }
}
