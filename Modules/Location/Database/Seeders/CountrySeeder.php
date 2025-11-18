<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Location\Http\Models\Country;

class CountrySeeder extends Seeder
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
            ['id' => $id++, 'name' => "Bangladesh", 'nationality' => "Bangladeshi", 'order' => 0, 'is_default' => 1, 'code'   => 'BD', 'status' => 1],
        ];
        Country::upsert($data, ['name']);
    }
}
