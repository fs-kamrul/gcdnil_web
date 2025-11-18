<?php

return [
    'name' => 'contactform::contact.settings.email.title',
    'description' => 'contactform::contact.settings.email.description',
    'templates' => [
        'notice' => [
            'title' => 'contactform::contact.settings.email.templates.notice_title',
            'description' => 'contactform::contact.settings.email.templates.notice_description',
            'subject' => 'Message sent via your contact form from {{ site_title }}',
            'can_off' => true,
            'variables' => [
                'contact_name' => 'Contact name',
                'contact_subject' => 'Contact subject',
                'contact_email' => 'Contact email',
                'contact_phone' => 'Contact phone',
                'contact_address' => 'Contact address',
                'contact_content' => 'Contact content',
            ],
        ],
    ],
];
