<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Http\Models\OptionBloodGroup;

class OptionBloodGroupSeeder extends Seeder
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
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "A+", 'slug' => "a+", 'order' => 0, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "A-", 'slug' => "a-", 'order' => 1, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "B+", 'slug' => "b-", 'order' => 2, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "AB+", 'slug' => "ab+", 'order' => 3, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "AB-", 'slug' => "ab-", 'order' => 4, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "O+", 'slug' => "o+", 'order' => 5, 'status' => 'active', 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "O-", 'slug' => "o-", 'order' => 6, 'status' => 'active', 'user_id' => 1 ],
        ];

        OptionBloodGroup::upsert($data, ['name']);
    }
}
