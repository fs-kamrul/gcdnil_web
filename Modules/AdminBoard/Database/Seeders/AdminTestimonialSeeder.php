<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Modules\AdminBoard\Http\Models\AdminTestimonial;
use Modules\KamrulDashboard\Http\Models\Slug;
use SlugHelper;

class AdminTestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
//        $id = 1;
        $data = [];
        $data_slug = [];
        $order = 0;
//        $data = [
//            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "One", 'slug' => "one", 'description' => "one", 'short_description' => "one", 'order' => $order++,
//                'set_time' => '3:00 PM - 4:00 PM','start_date' => '2024-08-31','location' => '102/1, Sukrabad, Dhaka', 'status' => 'active', 'user_id' => 1 ],
//        ];
        for ($i = 1; $i <= 24; $i++) {
            $name = $faker->name; // Generates a title with 3 words
            $slug = Str::slug($name);
            $description = $faker->text; // Generates a paragraph with 6 sentences
            $designation = $faker->jobTitle;
            $phone = $faker->phoneNumber;
            $email = $faker->email;
            $short_description = $faker->sentence(10);

            $data[] = [
                'id' => $i,
                'uuid' => Str::uuid(),
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'short_description' => $short_description,
                'designation' => $designation,
                'phone' => $phone,
                'email' => $email,
                'photo' => 'photo-12345.webp',
                'order' => $order++,
                'status' => 'active',
                'user_id' => 1,
            ];
            $data_slug[] = [
                'key'               => $slug,
                'reference_id'      => $i,
                'reference_type'    => AdminTestimonial::class,
                'prefix'            => SlugHelper::getPrefix(AdminTestimonial::class),
            ];
        }
        Slug::where('reference_type',AdminTestimonial::class)->delete();
        AdminTestimonial::upsert($data, ['name']);
//        Slug::upsert($data_slug, ['key']);
    }
}
