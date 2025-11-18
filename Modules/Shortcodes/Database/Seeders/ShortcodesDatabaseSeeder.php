<?php

namespace Modules\Shortcodes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ShortcodesDatabaseSeeder extends Seeder
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
//                ShortcodesPermissionSeeder::class,
            ]
        );
    }
}
