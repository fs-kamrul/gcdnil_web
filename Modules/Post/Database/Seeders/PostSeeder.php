<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Branch\Http\Models\PostBranch;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\Post\Http\Models\Post;
use Modules\Post\Http\Models\PostCategory;
use SlugHelper;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 1;

        $designation = ['Admin Officer' => 'Admin Officer', 'IT Officer' => 'IT Officer', 'Teacher' => 'Teacher' , 'Developer' => 'Developer', 'Chief Technical Officer' => 'Chief Technical Officer'];
        $data = [
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'header_title'  => null,
                'tag_line'      => null,
                'name'          => "Pre School",
                'slug'          => "Pre-school",
                'description'   => "This section covers classes from Playgroup to Kindergarten 2. Students of this section are in their first stage of learning where they begin their preschool and early learning. Children being very young at this stage have impressionable minds that need a caring environment. Starting with training to hold a pencil through games, songs, storytelling and a lot of innovativeness, they end up being capable and confident pupils who can clearly express themselves both in speech and in writing.",
                'photo'         => 'pre.png',
                'document_file' => null,
                'designation'   => null,
                'post_types_id' => 1,
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'header_title'  => null,
                'tag_line'      => null,
                'name'          => "Primary Section",
                'slug'          => "primary-section",
                'description'   => "As a School we cover a broad range of topics in our teaching. Because all of our teaching staff are involved in world-class teaching, all students receive an up-to-date curriculum of international standard. We are a dynamic and friendly School and actively encourage student involvement with biological study. Our teaching laboratories are among the best equipped of any institution in Bangladesh. We provide interactive microscopy, computing, and image analysis which in turn enable peer-to-peer learning of student findings, teacher's feedback and life-long educational impact.",
                'photo'         => 'junior.png',
                'document_file' => null,
                'designation'   => null,
                'post_types_id' => 1,
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'header_title'  => null,
                'tag_line'      => null,
                'name'          => "Secondary Section",
                'slug'          => "secondary-section",
                'description'   => "As a School we cover a broad range of topics in our teaching. Because all of our teaching staff are involved in world-class teaching, all students receive an up-to-date curriculum of international standard. We are a dynamic and friendly School and actively encourage student involvement with biological study. Our teaching laboratories are among the best equipped of any institution in Bangladesh. We provide interactive microscopy, computing, and image analysis which in turn enable peer-to-peer learning of student findings, teacher's feedback and life-long educational impact.",
                'photo'         => 'middle.png',
                'document_file' => null,
                'designation'   => null,
                'post_types_id' => 1,
                'status'        => 1,
                'user_id'       => 1,
            ],
            [
                'id'            => $id++,
                'uuid'          => gen_uuid(),
                'header_title'  => null,
                'tag_line'      => null,
                'name'          => "Higher Secondary Section",
                'slug'          => "higher-secondary-section",
                'description'   => "As a School we cover a broad range of topics in our teaching. Because all of our teaching staff are involved in world-class teaching, all students receive an up-to-date curriculum of international standard. We are a dynamic and friendly School and actively encourage student involvement with biological study. Our teaching laboratories are among the best equipped of any institution in Bangladesh. We provide interactive microscopy, computing, and image analysis which in turn enable peer-to-peer learning of student findings, teacher's feedback and life-long educational impact.",
                'photo'         => 'senior.png',
                'document_file' => null,
                'designation'   => null,
                'post_types_id' => 1,
                'status'        => 1,
                'user_id'       => 1,
            ],
        ];
        $post_slug = array();
        $post_category = array();

        foreach ($data as $key=>$value){
            if($value['id'] >= 1 && $value['id'] <= 4){
                $category_id = 2;
            }else{
                $category_id = 1;
            }
            $data_category = [
                'id'            => $key+1,
                'category_id'   => $category_id,
                'post_id'       => $value['id'],
            ];
            if($category_id != 1) {
                array_push($post_category, $data_category);
            }
        }
        foreach ($data as $key=>$value){
            $data_slug = [
                'id'                => $key+91,
                'key'               => $value['slug'],
                'reference_id'      => $value['id'],
                'reference_type'    => Post::class,
                'prefix'            => SlugHelper::getPrefix(Post::class),
            ];
            array_push($post_slug,$data_slug);
        }
        Post::upsert($data, ['name']);
        PostCategory::upsert($post_category, ['id']);
        Slug::upsert($post_slug, ['key']);
    }
}
