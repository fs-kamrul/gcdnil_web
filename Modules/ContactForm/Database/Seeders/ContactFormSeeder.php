<?php

namespace Modules\ContactForm\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContactForm\Http\Models\ContactForm;
use Modules\ContactForm\Http\Models\ContactFormReplie;

class ContactFormSeeder extends Seeder
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
                'name'          => "Kamrul Islam",
                'email'         => "kamrul@gmail.com",
                'phone'         => "01738256825",
                'address'       => "Dhanmondi",
                'subject'       => "Your site detail",
                'content'       => "Here are some of the most useful online tools that will help you know every single detail of any website",
                'status'        => 1,
            ],
            [
                'id'            => 2,
                'name'          => "Farhan Tanvir",
                'email'         => "farhan@gmail.com",
                'phone'         => "017",
                'address'       => "gulshn",
                'subject'       => "Website Checker",
                'content'       => "The Website Checker analyzes your website to see how well equipped it is for success online, and gives you tips on how you can improve it.",
                'status'        => 1,
            ],
        ];
        $contact_form = [
            [
                'id'                => 1,
                'message'           => 'Here are some of the most useful online tools that will help you know every single detail of any website',
                'contact_form_id'   => 1,
            ],
            [
                'id'                => 2,
                'message'           => 'The Website Checker analyzes your website to see how well equipped it is for success online, and gives you tips on how you can improve it.',
                'contact_form_id'   => 2,
            ],
        ];

        ContactForm::upsert($data, ['name']);
        ContactFormReplie::upsert($contact_form, ['id']);
    }
}
