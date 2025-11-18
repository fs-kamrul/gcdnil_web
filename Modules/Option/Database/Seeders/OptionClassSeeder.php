<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Http\Models\OptionClass;

class OptionClassSeeder extends Seeder
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
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "One", 'slug' => "one", 'order' => 0, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Two", 'slug' => "two", 'order' => 1, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Three", 'slug' => "three", 'order' => 2, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Four", 'slug' => "four", 'order' => 3, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Five", 'slug' => "five", 'order' => 4, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Six", 'slug' => "six", 'order' => 5, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Seven", 'slug' => "seven", 'order' => 6, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Eight", 'slug' => "eight", 'order' => 7, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Nine", 'slug' => "nine", 'order' => 8, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Ten", 'slug' => "ten", 'order' => 9, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Eleven", 'slug' => "eleven", 'order' => 10, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Twelve", 'slug' => "twelve", 'order' => 11, 'status' => 1, 'user_id' => 1 ],
        ];

        OptionClass::upsert($data, ['name']);
    }
}
