<?php

namespace Modules\Theme\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\SettingData;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'key'     => "theme",                 'value'  => "CdcTheme"],
            [ 'key'     => "theme-CdcTheme-site_title",            'value'  => "Laravel Website"],
            [ 'key'     => "theme-CdcTheme-site_description",      'value'  => 'Website description'],
            [ 'key'     => "theme-CdcTheme-copyright",             'value'  => '©' . now()->format('Y') . ' Laravel Website'],
            [ 'key'     => "theme-CdcTheme-address",               'value'  => 'Dhanmondi 14, subanbag, Dhaka 1200'],
            [ 'key'     => "theme-CdcTheme-site_email",            'value'  => 'info@dis.edu.bd'],
            [ 'key'     => "theme-CdcTheme-site_phone",            'value'  => '+88 01713 493 226'],
            [ 'key'     => "theme-CdcTheme-designed_by",           'value'  => 'Designed by Kamrul | All rights reserved.'],
            [ 'key'     => "theme-CdcTheme-social_1_name",         'value'  => "Facebook"],
            [ 'key'     => "theme-CdcTheme-social_1_icon",         'value'  => "fa-brands fa-facebook-f"],
            [ 'key'     => "theme-CdcTheme-social_1_url",          'value'  => "https://facebook.com"],
            [ 'key'     => "theme-CdcTheme-social_1_color",        'value'  => "#3B5999"],
            [ 'key'     => "theme-CdcTheme-social_2_name",         'value'  => "Twitter"],
            [ 'key'     => "theme-CdcTheme-social_2_icon",         'value'  => "fa-brands fa-twitter"],
            [ 'key'     => "theme-CdcTheme-social_2_url",          'value'  => "https://twitter.com"],
            [ 'key'     => "theme-CdcTheme-social_2_color",        'value'  => "#55ACF9"],
            [ 'key'     => "theme-CdcTheme-social_3_name",         'value'  => "Linkedin"],
            [ 'key'     => "theme-CdcTheme-social_3_icon",         'value'  => "fa-brands fa-instagram"],
            [ 'key'     => "theme-CdcTheme-social_3_url",          'value'  => "https://linkedin.com"],
            [ 'key'     => "theme-CdcTheme-social_3_color",        'value'  => "#0A66C2"],
            [ 'key'     => "theme-CdcTheme-social_4_name",         'value'  => "Youtube"],
            [ 'key'     => "theme-CdcTheme-social_4_icon",         'value'  => "fa-brands fa-youtube"],
            [ 'key'     => "theme-CdcTheme-social_4_url",          'value'  => "https://youtube.com"],
            [ 'key'     => "theme-CdcTheme-social_4_color",        'value'  => "#EF1111"],
            [ 'key'     => "theme-CdcTheme-social_5_name",         'value'  => "Linkedin"],
            [ 'key'     => "theme-CdcTheme-social_5_icon",         'value'  => "fa-brands fa-linkedin-in"],
            [ 'key'     => "theme-CdcTheme-social_5_url",          'value'  => "https://www.linkedin.com"],
            [ 'key'     => "theme-CdcTheme-social_5_color",        'value'  => "#EF1111"],
            [ 'key'     => "theme-CdcTheme-homepage_id",           'value'  => "1"],
            [ 'key'     => "theme-CdcTheme-favicon",               'value'  => "2"],
            [ 'key'     => "theme-CdcTheme-logo",                  'value'  => "3"],
            [ 'key'     => "theme-CdcTheme-seo_og_image",          'value'  => "4"],

            [ 'key'     => "theme-CdcTheme-primary_color",         'value'  => "#4188E5"],
            [ 'key'     => "theme-CdcTheme-secondary_color",       'value'  => "#FFB703"],
            [ 'key'     => "theme-CdcTheme-background_color",      'value'  => "#edf6fa"],
            [ 'key'     => "theme-CdcTheme-danger_color",          'value'  => "#e3363e"],
        ];

        SettingData::upsert($data, ['key']);
    }
}
