<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Modules\AdminBoard\Http\Models\AdminEducation;
use Modules\KamrulDashboard\Http\Models\Slug;
use SlugHelper;

class AdminEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $id = 1;
        $data = [];
        $data_slug = [];
        $order = 0;
        $data = [
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Masters", 'slug' => "masters", 'order' => $order++, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Graduation", 'slug' => "graduation", 'order' => $order++, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "HSC", 'slug' => "hsc", 'order' => $order++, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "SSC", 'slug' => "ssc", 'order' => $order++, 'status' => 'active', 'user_id' => 1 ],
        ];
//        for ($i = 1; $i <= 10; $i++) {
//            $name = $faker->name; // Generates a title with 3 words
//            $slug = Str::slug($name);
//
//            $data[] = [
//                'id' => $i,
//                'uuid' => Str::uuid(),
//                'name' => $name,
//                'slug' => $slug,
////                'photo' => $i.'.png',
//                'order' => $order++,
//                'status' => 'active',
//                'user_id' => 1,
//            ];
//            $data_slug[] = [
//                'key'               => $slug,
//                'reference_id'      => $i,
//                'reference_type'    => AdminEducation::class,
//                'prefix'            => SlugHelper::getPrefix(AdminEducation::class),
//            ];
//        }
//        Slug::where('reference_type',AdminEducation::class)->delete();
        AdminEducation::upsert($data, ['name']);
//        Slug::upsert($data_slug, ['key']);
    }
}
