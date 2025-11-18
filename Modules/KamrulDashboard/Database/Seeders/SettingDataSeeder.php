<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\SettingData;

class SettingDataSeeder extends Seeder
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
                'key'         => "theme-CdcTheme-action_title_text",
                'value'        => "Freshers' Orientation Program for the Session: 2022 - 23",
            ],
        ];

        SettingData::upsert($data, ['key']);
    }
}
