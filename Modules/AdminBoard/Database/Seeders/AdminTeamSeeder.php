<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\KamrulDashboard\Http\Models\Slug;
use SlugHelper;

class AdminTeamSeeder extends Seeder
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
            $description = $faker->paragraph(70); // Generates a paragraph with 6 sentences
            $short_description = $faker->sentence(10); // Generates a short sentence
            $designation = $faker->jobTitle;
            $email = $faker->unique()->safeEmail;
            $phone = $faker->phoneNumber;

            $data[] = [
                'id' => $i,
                'uuid' => Str::uuid(),
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'short_description' => $short_description,
                'designation' => $designation,
                'email' => $email,
                'phone' => $phone,
                'photo' => 'photo-12345.webp',
                'facebook_id' => $faker->userName, // Simulates a Facebook ID
                'google_site' => $faker->userName,       // Simulates a Google site URL
                'linkedin_id' => $faker->userName,  // Simulates a LinkedIn ID
                'father_name' => $faker->name,  // Simulates a LinkedIn ID
                'mother_name' => $faker->name,  // Simulates a LinkedIn ID
                'dob' => $faker->date,  // Simulates a LinkedIn ID
                'office_address' => $faker->address,  // Simulates a LinkedIn ID
                'order' => $order++,
                'status' => 'active',
                'user_id' => 1,
            ];
            $data_slug[] = [
                'key'               => $slug,
                'reference_id'      => $i,
                'reference_type'    => AdminTeam::class,
                'prefix'            => SlugHelper::getPrefix(AdminTeam::class),
            ];
        }
        Slug::where('reference_type',AdminTeam::class)->delete();
//        SlugInterface::
//        print_r($data_slug);
        AdminTeam::upsert($data, ['name']);
        Slug::upsert($data_slug, ['key']);
    }
}
