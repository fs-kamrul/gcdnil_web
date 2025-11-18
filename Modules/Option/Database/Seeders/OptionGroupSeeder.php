<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Http\Models\OptionGroup;


class OptionGroupSeeder extends Seeder
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
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "None", 'slug' => "none", 'order' => 0, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Science", 'slug' => "science", 'order' => 1, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Humanities", 'slug' => "humanities", 'order' => 2, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Commerce", 'slug' => "commerce", 'order' => 3, 'status' => 1, 'user_id' => 1 ],
        ];

        OptionGroup::upsert($data, ['name']);
    }
}
