<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PostDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(
            [
                PostPermissionSeeder::class,
                PageTemplatePermissionSeeder::class,

                PagePermissionSeeder::class,
                PostTypePermissionSeeder::class,
                CategoryPermissionSeeder::class,

                CategorySeeder::class,
                PostTypeSeeder::class,
                PostSeeder::class,

                PageTemplateSeeder::class,
                PageSeeder::class,
                PostGallerySeeder::class,

            ]
        );
    }
}




