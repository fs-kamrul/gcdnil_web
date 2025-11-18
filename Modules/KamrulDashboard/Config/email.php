<?php

return [
    'name' => 'kamruldashboard::setting.email.template_title',
    'description' => 'kamruldashboard::setting.email.template_description',
    'templates' => [
        'header' => [
            'title' => 'kamruldashboard::setting.email.template_header',
            'description' => 'kamruldashboard::setting.email.template_header_description',
        ],
        'footer' => [
            'title' => 'kamruldashboard::setting.email.template_footer',
            'description' => 'kamruldashboard::setting.email.template_footer_description',
        ],
        'password-reminder' => [
            'title' => 'Reset password',
            'description' => 'Send email to user when requesting reset password',
            'subject' => 'Reset Password',
            'can_off' => false,
            'variables' => [
                'reset_link' => 'Reset password link',
            ],
        ],
        'test' => [
            'title' => 'kamruldashboard::setting.email.test_email',
            'description' => 'kamruldashboard::setting.email.test_email_description',
            'subject' => 'Message sent Test mail',
            'can_off' => false,
//            'can_off' => true,
        ],
    ],
];
