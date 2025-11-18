<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Http\Models\OptionGender;

class OptionGenderSeeder extends Seeder
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
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Male", 'slug' => "male", 'order' => 0, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Female", 'slug' => "female", 'order' => 1, 'status' => 1, 'user_id' => 1 ],
        ];

        OptionGender::upsert($data, ['name']);
    }
}
