<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Post\Http\Models\PostGallery;
use Modules\Post\Http\Models\PostGalleryParameter;

class PostGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id'            => 1,
                'name'          => "diss.png",
                'user_id'       => 1,
            ],
        ];
        PostGallery::upsert($data, ['name']);
    }
}
