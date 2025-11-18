<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Option\Http\Models\OptionSubject;

class OptionSubjectSeeder extends Seeder
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
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Bangla", 'slug' => "bangla", 'code' => '101', 'total_mark' => 100, 'class_id' => 1, 'order' => 0, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "English", 'slug' => "english", 'code' => '102', 'total_mark' => 100, 'class_id' => 1, 'order' => 1, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Mathematics", 'slug' => "mathematics", 'code' => '103', 'total_mark' => 100, 'class_id' => 1, 'order' => 2, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Information and Communication Technology (ICT)", 'slug' => "science", 'code' => '104', 'total_mark' => 100, 'class_id' => 1, 'order' => 3, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Civics and Good Governance", 'slug' => "civics-and-good-governance", 'code' => '105', 'total_mark' => 100, 'class_id' => 1, 'order' => 4, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Sociology", 'slug' => "sociology", 'code' => '106', 'total_mark' => 100, 'class_id' => 1, 'order' => 5, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Economics", 'slug' => "economics", 'code' => '107', 'total_mark' => 100, 'class_id' => 1, 'order' => 6, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Logic", 'slug' => "logic", 'code' => '108', 'total_mark' => 100, 'class_id' => 1, 'order' => 7, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Geography", 'slug' => "geography", 'code' => '109', 'total_mark' => 100, 'class_id' => 1, 'order' => 8, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "History", 'slug' => "history", 'code' => '110', 'total_mark' => 100, 'class_id' => 1, 'order' => 9, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Islamic History", 'slug' => "islamic-history", 'code' => '111', 'total_mark' => 100, 'class_id' => 1, 'order' => 10, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Agricultural Education", 'slug' => "agricultural-education", 'code' => '112', 'total_mark' => 100, 'class_id' => 1, 'order' => 11, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Psychology", 'slug' => "psychology", 'code' => '113', 'total_mark' => 100, 'class_id' => 1, 'order' => 12, 'status' => 1, 'user_id' => 1 ],
            [ 'id' => $id++, 'uuid' => gen_uuid(), 'name' => "Statistics", 'slug' => "statistics", 'code' => '114', 'total_mark' => 100, 'class_id' => 1, 'order' => 13, 'status' => 1, 'user_id' => 1 ],
        ];
        OptionSubject::upsert($data, ['name']);
    }
}
