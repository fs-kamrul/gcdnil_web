<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Http\Models\OptionReligion;

class OptionReligionSeeder extends Seeder
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
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Islam", 'slug' => "islam", 'order' => 0, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Hinduism", 'slug' => "hinduism", 'order' => 1, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Buddhism", 'slug' => "buddhism", 'order' => 2, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Christianity", 'slug' => "christianity", 'order' => 3, 'status' => 1, 'user_id' => 1 ],
        ];

        OptionReligion::upsert($data, ['name']);
    }
}
