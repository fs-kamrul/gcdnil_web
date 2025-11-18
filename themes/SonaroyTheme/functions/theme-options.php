<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id'         => 'copyright',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Copyright'),
            'attributes' => [
                'name'    => 'copyright',
                'value'   => '© 2022 Apphostbd Technologies. All right reserved.',
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => __('Change copyright'),
                    'data-counter' => 250,
                ],
            ],
            'helper'     => __('Copyright on footer of site'),
        ])
        ->setField([
            'id'         => 'designed_by',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Designed by'),
            'attributes' => [
                'name'    => 'designed_by',
                'value'   => 'Designed by Kamrul | All rights reserved.',
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 250,
                ],
            ],
        ])
        ->setField([
            'id'         => 'preloader_enabled',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Enable Preloader?'),
            'attributes' => [
                'name'    => 'preloader_enabled',
                'list'    => [
                    'no'  => trans('theme::theme.no'),
                    'yes' => trans('theme::theme.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
//        ->setField([
//            'id'         => 'primary_font',
//            'section_id' => 'opt-text-subsection-general',
//            'type'       => 'googleFonts',
//            'label'      => __('Primary font'),
//            'attributes' => [
//                'name'  => 'primary_font',
//                'value' => 'Roboto',
//            ],
//        ])
        ->setField([
            'id'         => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Primary color'),
            'attributes' => [
                'name'  => 'primary_color',
                'value' => '#edf6fa',
            ],
        ])
        ->setField([
            'id'         => 'secondary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Secondary color'),
            'attributes' => [
                'name'  => 'secondary_color',
                'value' => '#2d3d8b',
            ],
        ])
        ->setField([
            'id'         => 'background_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Background color'),
            'attributes' => [
                'name'  => 'background_color',
                'value' => '#edf6fa',
            ],
        ])
        ->setField([
            'id'         => 'danger_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Danger color'),
            'attributes' => [
                'name'  => 'danger_color',
                'value' => '#e3363e',
            ],
        ])
        ->setField([
            'id'         => 'site_description',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'textarea',
            'label'      => __('Site description'),
            'attributes' => [
                'name'    => 'site_description',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setField([
            'id'         => 'address',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Address'),
            'attributes' => [
                'name'    => 'address',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setField([
            'id'         => 'address_google',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Google Share Address URL'),
            'attributes' => [
                'name'    => 'address_google',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                    'placeholder' => 'https://goo.gl/maps/******',
                ],
            ],
        ])
        ->setField([
            'id'         => 'site_email',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'email',
            'label'      => __('Email'),
            'attributes' => [
                'name'    => 'site_email',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setField([
            'id'         => 'site_email2',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'email',
            'label'      => __('2nd Email'),
            'attributes' => [
                'name'    => 'site_email2',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setField([
            'id'         => 'site_phone',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Phone'),
            'attributes' => [
                'name'    => 'site_phone',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setField([
            'id'         => 'site_phone2',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('2nd Phone'),
            'attributes' => [
                'name'    => 'site_phone2',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setField([
            'id'         => 'working_hours',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Working Hours'),
            'attributes' => [
                'name'    => 'working_hours',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 255,
                ],
            ],
        ])
        ->setSection([
            'title'      => __('Social'),
            'desc'       => __('Social links'),
            'id'         => 'opt-text-subsection-social-links',
            'subsection' => true,
            'icon'       => 'fa fa-share-alt',
        ]);

    for ($i = 1; $i <= 6; $i++) {
        theme_option()
            ->setField([
                'id'         => 'social_' . $i . '_name',
                'section_id' => 'opt-text-subsection-social-links',
                'type'       => 'text',
                'label'      => __('Name') . ' ' . $i,
                'attributes' => [
                    'name'    => 'social_' . $i . '_name',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ])
            ->setField([
                'id'         => 'social_' . $i . '_icon',
                'section_id' => 'opt-text-subsection-social-links',
                'type'       => 'text',
                'label'      => __('Icon') . ' ' . $i,
                'attributes' => [
                    'name'    => 'social_' . $i . '_icon',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ])
            ->setField([
                'id'         => 'social_' . $i . '_url',
                'section_id' => 'opt-text-subsection-social-links',
                'type'       => 'text',
                'label'      => __('URL') . ' ' . $i,
                'attributes' => [
                    'name'    => 'social_' . $i . '_url',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ])
            ->setField([
                'id'         => 'social_' . $i . '_color',
                'section_id' => 'opt-text-subsection-social-links',
                'type'       => 'customColor',
                'label'      => __('Color') . ' ' . $i,
                'attributes' => [
                    'name'    => 'social_' . $i . '_color',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ]);
    }

    theme_option()
//        ->setSection([
//            'title'      => __('Header'),
//            'desc'       => __('Header config'),
//            'id'         => 'opt-text-subsection-header',
//            'subsection' => true,
//            'icon'       => 'fa fa-link',
//        ])
//        ->setField([
//            'id'         => 'action_title_text',
//            'section_id' => 'opt-text-subsection-header',
//            'type'       => 'text',
//            'label'      => __('Header Title'),
//            'attributes' => [
//                'name'    => 'action_title_text',
//                'value'   => 'Freshers\' Orientation Program for the Session: 2022 - 23',
//                'options' => [
//                    'class' => 'form-control',
//                ],
//            ],
//        ])
//        ->setField([
//            'id'         => 'action_button_text',
//            'section_id' => 'opt-text-subsection-header',
//            'type'       => 'text',
//            'label'      => __('Action button text'),
//            'attributes' => [
//                'name'    => 'action_button_text',
//                'value'   => null,
//                'options' => [
//                    'class' => 'form-control',
//                ],
//            ],
//        ])
//        ->setField([
//            'id'         => 'action_button_url',
//            'section_id' => 'opt-text-subsection-header',
//            'type'       => 'text',
//            'label'      => __('Action button URL'),
//            'attributes' => [
//                'name'    => 'action_button_url',
//                'value'   => null,
//                'options' => [
//                    'class' => 'form-control',
//                ],
//            ],
//        ])
        ->setField([
            'id'         => 'blog_single_layout',
            'section_id' => 'opt-text-subsection-blog',
            'type'       => 'select',
            'label'      => __('Default Page Single Layout'),
            'attributes' => [
                'name'    => 'blog_single_layout',
                'list'    => get_blog_single_layouts(),
                'value'   => 'blog-full-width',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'blog_layout',
            'section_id' => 'opt-text-subsection-blog',
            'type'       => 'select',
            'label'      => __('Public Layout'),
            'attributes' => [
                'name'    => 'blog_layout',
                'list'    => get_blog_layouts(),
                'value'   => 'big',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'facebook_comment_enabled_in_gallery',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'select',
            'label'      => __('Enable Facebook comment in the gallery detail?'),
            'attributes' => [
                'name'    => 'facebook_comment_enabled_in_gallery',
                'list'    => [
                    'no'  => trans('theme::theme.no'),
                    'yes' => trans('theme::theme.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ]);
    theme_option()
        ->setSection([
            'title'      => __('Daffodil Smart'),
            'desc'       => __('Banner Action config'),
            'id'         => 'opt-text-subsection-banner-action',
            'subsection' => true,
            'icon'       => 'icon-zoom-in',
        ])
        ->setField([
            'id'         => 'action_space_text',
            'section_id' => 'opt-text-subsection-banner-action',
            'type'       => 'text',
            'label'      => __('Space'),
            'attributes' => [
                'name'    => 'action_space_text',
                'value'   => '20Ac',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'action_menu_text',
            'section_id' => 'opt-text-subsection-banner-action',
            'type'       => 'text',
            'label'      => __('Menu'),
            'attributes' => [
                'name'    => 'action_menu_text',
                'value'   => '50+',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'action_seats_text',
            'section_id' => 'opt-text-subsection-banner-action',
            'type'       => 'text',
            'label'      => __('Seats'),
            'attributes' => [
                'name'    => 'action_seats_text',
                'value'   => '10K',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ]);
    theme_option()
        ->setSection([
            'title'      => __('Venue Massage'),
            'desc'       => __('Venue Massage config'),
            'id'         => 'opt-text-venue-massage-action',
            'subsection' => true,
            'icon'       => 'icon-envelope2',
        ])
        ->setField([
            'id'         => 'action_venue_title_text',
            'section_id' => 'opt-text-venue-massage-action',
            'type'       => 'text',
            'label'      => __('Title'),
            'attributes' => [
                'name'    => 'action_venue_title_text',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'action_venue_massage_text',
            'section_id' => 'opt-text-venue-massage-action',
            'type'       => 'text',
            'label'      => __('Massage'),
            'attributes' => [
                'name'    => 'action_venue_massage_text',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'action_venue_contact_us_text',
            'section_id' => 'opt-text-venue-massage-action',
            'type'       => 'text',
            'label'      => __('Contact us URL'),
            'attributes' => [
                'name'    => 'action_venue_contact_us_text',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setSection([
            'title' => __('Contact info boxes'),
            'desc' => __('Contact info boxes'),
            'id' => 'opt-contact',
            'subsection' => false,
            'icon' => 'fa fa-info-circle',
            'fields' => [],
        ])
        ->setField([
            'id' => 'contact_info_boxes',
            'section_id' => 'opt-contact',
            'type' => 'repeater',
            'label' => __('Contact info boxes'),
            'attributes' => [
                'name' => 'contact_info_boxes',
                'value' => null,
                'fields' => [
                    [
                        'type' => 'text',
                        'label' => __('Name'),
                        'attributes' => [
                            'name' => 'name',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => __('Contact Person'),
                        'attributes' => [
                            'name' => 'contact',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => __('Person Designation'),
                        'attributes' => [
                            'name' => 'designation',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => __('Address'),
                        'attributes' => [
                            'name' => 'address',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => __('Phone'),
                        'attributes' => [
                            'name' => 'phone',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'type' => 'email',
                        'label' => __('Email'),
                        'attributes' => [
                            'name' => 'email',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
//        ->setField([
//            'id'         => 'action_subsection_text',
//            'section_id' => 'opt-text-subsection-banner-action',
//            'type'       => 'text',
//            'label'      => __('Subjects'),
//            'attributes' => [
//                'name'    => 'action_subjects_text',
//                'value'   => '40+',
//                'options' => [
//                    'class' => 'form-control',
//                ],
//            ],
//        ]);
});
