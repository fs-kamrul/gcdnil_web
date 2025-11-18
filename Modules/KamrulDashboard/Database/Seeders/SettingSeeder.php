<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Setting;

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
            [
                'id'            => 1,
                'title'         => "Site Setting",
                'key'           => "site_setting",
                'slug'          => "site-setting",
                'description'   => 'Here you can manage the title, logo, favicon and all general settings',
                'settings_data' => '{"site_name":{"value":"Apps name","type":"text","extra":"","tool_tip":"Site Name"},"site_favicon":{"value":"..\/..\/vendor\/kamruldashboard\/images\/125.png","type":"file","extra":"","tool_tip":"Favicon"},"site_logo":{"value":"..\/..\/vendor\/kamruldashboard\/images\/124.png","type":"file","extra":"","tool_tip":"Site logo"},"footer":{"value":"<p>Copyright \u00a9 KamrulDshboard &amp; Developed by <a href=\"#\" target=\"_blank\">Daffodil International School<\/a> 2021<\/p>\r\n<p>Distributed by <a href=\"\" target=\"_blank\">Kamrul<\/a><\/p>","type":"textarea","extra":"","tool_tip":"Footer"},"registration_enable":{"value":"1","type":"checkbox","extra":"","tool_tip":"Registration Enable"},"registration_user_role":{"value":"1","type":"checkbox","extra":"","tool_tip":"Registration User Role"}}',
                'photo'         => '../../vendor/kamruldashboard/images/123.jpg',
            ],
            [
                'id'            => 2,
                'title'         => "Email Settings",
                'key'           => "email_settings",
                'slug'          => "email-settings",
                'description'   => 'Contains all the settings related to emails',
                'settings_data' => '{"mail_driver":{"value":"smtp","type":"select","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Driver"},"mail_host":{"value":"mail.admin.com","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Host"},"mail_port":{"value":"25","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Port no"},"mail_username":{"value":"admin@admin.com","type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Username"},"mail_password":{"value":"123456","type":"password","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Password"},"mail_encryption":{"value":0,"type":"text","extra":{"total_options":"8","options":{"smtp":"SMTP","mail":"Mail","sparkpost":"Sparkpost","sendmail":"Sendmail","mailgun":"Mailgun","mandrill":"Mandrill","ses":"SES","log":"Log"}},"tool_tip":"Mail Encryption"}}',
                'photo'         => null,
            ],
            [
                "id" => 3,
                "title" => "Google Analytics",
                "key" => "google_analytics",
                "slug" => "google-analytics",
                "description" => "Config Credentials for Google Analytics",
                "settings_data" => '{"google_analytics":{"value":"","type":"text","extra":"","tool_tip":"Tracking ID"},"analytics_view_id":{"value":"","type":"text","extra":"","tool_tip":"Google Analytics View ID"},"analytics_service_account_credentials":{"type":"textarea","value":"","extra":[],"tool_tip":"Analytics Service Account Credentials"}}',
                "photo" => null,
]
        ];

//        Setting::insert($data);
        Setting::upsert($data, ['key']);
    }
}
