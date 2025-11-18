<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Modules\AdminBoard\Http\Models\AdminFacility;
use Modules\KamrulDashboard\Http\Models\Slug;
use SlugHelper;

class AdminFacilitySeeder extends Seeder
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
            $name = $faker->sentence(3); // Generates a title with 3 words
            $slug = Str::slug($name);
            $description = $faker->paragraph(70); // Generates a paragraph with 6 sentences
            $short_description = $faker->sentence(10); // Generates a short sentence
//            $set_time = $faker->time('h:i A') . ' - ' . $faker->time('h:i A'); // Generates a time range
//            $start_date = $faker->date('Y-m-d'); // Generates a random date
//            $location = $faker->address; // Generates a random address

            $data[] = [
                'id' => $i,
                'uuid' => Str::uuid(),
                'name' => $name,
                'icon' => $this->getRandomFontAwesomeIcon(),
                'short_description' => $short_description,
                'description' => $description,
                'slug' => $slug,
                'order' => $order++,
                'status' => 'active',
                'user_id' => 1,
            ];
            $data_slug[] = [
                'key'               => $slug,
                'reference_id'      => $i,
                'reference_type'    => AdminFacility::class,
                'prefix'            => SlugHelper::getPrefix(AdminFacility::class),
            ];
        }
        Slug::where('reference_type',AdminFacility::class)->delete();
//        SlugInterface::
//        print_r($data_slug);
        AdminFacility::upsert($data, ['name']);
        Slug::upsert($data_slug, ['key']);
    }
    private function getRandomFontAwesomeIcon()
    {
        $icons = [
            'fa fa-graduation-cap',
            'fa fa-user',
            'fa fa-check-circle-o',
            'fa fa-envelope',
            'fa fa-phone',
            'fa fa-car',
            'fa fa-bell',
            'fa fa-star',
            'fa fa-university',
            'fa fa-heart',
            'fa fa-star',
            'fa fa-camera',
        ];

        return $icons[array_rand($icons)];
    }
}
