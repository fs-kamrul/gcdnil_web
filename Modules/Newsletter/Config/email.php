<?php

return [
    'name' => 'newsletter::newsletter.settings.email.templates.title',
    'description' => 'newsletter::newsletter.settings.email.templates.description',
    'templates' => [
        'subscriber_email' => [
            'title' => 'newsletter::newsletter.settings.email.templates.to_user.title',
            'description' => 'newsletter::newsletter.settings.email.templates.to_user.description',
            'subject' => '{{ site_title }}: Subscription Confirmed!',
            'can_off' => true,
            'variables' => [
                'newsletter_name' => 'Full name of user who subscribe newsletter',
                'newsletter_email' => 'Email of user who subscribe newsletter',
                'newsletter_unsubscribe_link' => 'Link for unsubscribe newsletter',
            ],
        ],
        'admin_email' => [
            'title' => 'newsletter::newsletter.settings.email.templates.to_admin.title',
            'description' => 'newsletter::newsletter.settings.email.templates.to_admin.description',
            'subject' => 'New user subscribed your newsletter',
            'can_off' => true,
            'variables' => [
                'newsletter_email' => 'Email of user who subscribe newsletter',
            ],
        ],
    ],
    'variables' => [],
];
