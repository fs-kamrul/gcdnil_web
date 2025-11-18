<?php

//use Theme;
use Illuminate\Support\Arr;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PosttypeInterface;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Theme\Packages\Supports\ThemeSupport;
use Modules\Faq\Repositories\Interfaces\FaqInterface;
use Modules\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Modules\Ecommerce\Repositories\Interfaces\EcommerceProductCategoryInterface;
use Modules\Ecommerce\Repositories\Interfaces\EcommerceProductCollectionInterface;
use Modules\Mentor\Repositories\Interfaces\MentorInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminNoticeBoardInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminEventInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminNewsInterface;

app()->booted(function () {


    ThemeSupport::registerGoogleMapsShortcode(Theme::getThemeNamespace().'::partials.short-codes');
    ThemeSupport::registerYoutubeShortcode(Theme::getThemeNamespace().'::partials.short-codes');

    if (is_module_active('SimpleSlider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace() . '::partials.short-codes.sliders.main';
        }, 120);
    }

    add_shortcode('our-offices', __('Our offices'), __('Our offices'), function () {
        return Theme::partial('short-codes.our-offices');
    });

    shortcode()->setAdminConfig('our-offices', function ($attributes) {
        return Theme::partial('short-codes.our-offices-admin-config', compact('attributes'));
    });
    if (is_module_active('ContactForm')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.short-codes.contact-form';
        }, 120);
    }
//    if (is_module_active('Admission')) {
        add_filter(ADMISSION_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.short-codes.admission-form';
        }, 121);
//    }
    if (is_module_active('Post')) {

        add_shortcode('marquee-box', __('Marquee Box'), __('Add Marquee Box'),
            function ($shortcode) {
                return Theme::partial('short-codes.marquee-box', ['shortcode' => $shortcode]);
            });

        shortcode()->setAdminConfig('marquee-box', function ($attributes) {
            return Theme::partial('short-codes.marquee-box-admin-config', compact('attributes'));
        });
        add_shortcode('latest-news-blog', __('Latest Notice Board'), __('Add Latest Notice Board'),
            function ($shortcode) {
//                $attributes = $shortcode->toArray();
                $notice_boards = app(AdminNoticeBoardInterface::class)->advancedGet(['take' => 7, 'order_by' => ['created_at' => 'desc'],]);
//                $events = app(AdminEventInterface::class)->advancedGet(['take' => 5, 'order_by' => ['created_at' => 'desc'],]);
//                $news = app(AdminNewsInterface::class)->advancedGet(['take' => 5, 'order_by' => ['created_at' => 'desc'],]);
//                $workshops = app(AdminWorkshopInterface::class)->advancedGet(['take' => 2, 'order_by' => ['created_at' => 'desc'],]);
                return Theme::partial('short-codes.latest-news-blog', [
                    'shortcode' => $shortcode,
                    'notice_boards' => $notice_boards,
//                    'events' => $events,
//                    'news' => $news,
//                    'workshops' => $workshops,
                ]);
            });
        shortcode()->setAdminConfig('latest-news-blog', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.latest-news-blog-admin-config', compact('attributes','post_types'));
        });
//        add_shortcode('notice-board', __('Notice Board'), __('Add Notice Board'),
//            function ($shortcode) {
//                $attributes = $shortcode->toArray();
//                $post_types = app(PosttypeInterface::class)->advancedGet([
//                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
//                    'take'      => 1,
//                    'with'      => [
//                        'post' => function ($query) use ($attributes) {
//                            return $query
//                                ->latest()
//                                ->where('status', DboardStatus::PUBLISHED)
//                                ->limit(Arr::get($attributes, 'number_of_slide'));
//                        },
//                    ],
//                ]);
//                return Theme::partial('short-codes.notice-board', ['shortcode' => $shortcode,'post_types' => $post_types]);
//            });
//        shortcode()->setAdminConfig('notice-board', function ($attributes) {
//            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
//            return Theme::partial('short-codes.notice-board-admin-config', compact('attributes','post_types'));
//        });
        add_shortcode('all-notice-board', __('All Notice Board'), __('Add All Notice Board'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
//                return Theme::partial('short-codes.all-notice-board', ['shortcode' => $shortcode,'post_types' => $post_types]);
                $posts = $post_types->post()->orderBy('id', 'DESC')->Paginate((int)Arr::get($attributes, 'number_of_slide'));
                return Theme::partial('short-codes.all-notice-board', ['shortcode' => $shortcode,'posts' => $posts]);
            });
        shortcode()->setAdminConfig('all-notice-board', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.all-notice-board-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('management-board', __('Management Board'), __('Add Management Board'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
//                return Theme::partial('short-codes.all-notice-board', ['shortcode' => $shortcode,'post_types' => $post_types]);   // DESC
                $posts = $post_types->post()->orderBy('id', 'ASC')->Paginate((int)Arr::get($attributes, 'number_of_slide'));
                return Theme::partial('short-codes.management-board', ['shortcode' => $shortcode,'posts' => $posts]);
            });
        shortcode()->setAdminConfig('management-board', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.management-board-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('homepage-box', __('Homepage Box'), __('Add Homepage Box'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
//                $post_types = app(PosttypeInterface::class)->advancedGet([
//                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
//                    'take'      => 1,
//                    'with'      => [
//                        'post' => function ($query) use ($attributes) {
//                            return $query
//                                ->latest()
//                                ->where('status', DboardStatus::PUBLISHED)
//                                ->limit(Arr::get($attributes, 'number_of_slide'));
//                        },
//                    ],
//                ]);
                $numberOfPosts = Arr::get($attributes, 'number_of_slide', 5);
                $categories = app(CategoryInterface::class)->advancedGet([
                    'condition' => ['status' => DboardStatus::PUBLISHED],
                    'order_by'  => ['order' => 'asc'],
                    'with'      => [
                        'post' => function ($query) use ($numberOfPosts) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED);
//                                ->take($numberOfPosts);
//                                ->limit(Arr::get($attributes, 'number_of_slide'));
//                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
//                dd($categories);
                return Theme::partial('short-codes.homepage-box', ['shortcode' => $shortcode,'categories' => $categories]);
            });
        shortcode()->setAdminConfig('homepage-box', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.homepage-box-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('our-venues', __('Our Venues'), __('Add Our Venues'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.our-venues', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('our-venues', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.our-venues-admin-config', compact('attributes','post_types'));
        });
//        add_shortcode('div-start-class', __('Div Class Sections'), __('Add Div Class Sections'),
//            function ($shortcode) {
//                return "<section id='" . $shortcode->name . "'>";
////                return Theme::partial('short-codes.div-start-class', ['shortcode' => $shortcode]);
//            });
//        shortcode()->setAdminConfig('div-start-class', function ($attributes) {
//            return Theme::partial('short-codes.div-start-class-admin-config', compact('attributes'));
//        });
//        add_shortcode('div-end', __('Div End Sections'), __('Add Div End Sections'),
//            function ($shortcode) {
//                return "</section>";
////                return Theme::partial('short-codes.div-end-class', ['shortcode' => $shortcode]);
//            });
//        shortcode()->setAdminConfig('div-end', function ($attributes) {
//            return Theme::partial('short-codes.div-end-class-admin-config', compact('attributes'));
//        });
        add_shortcode('single-banner-sections', __('Single Banner Sections'), __('Add Single Banner Sections'),
            function ($shortcode) {
                return Theme::partial('short-codes.single-banner-sections', ['shortcode' => $shortcode]);
            });

        shortcode()->setAdminConfig('single-banner-sections', function ($attributes) {
            return Theme::partial('short-codes.single-banner-sections-admin-config', compact('attributes'));
        });
        add_shortcode('about-us', __('About Us'), __('Add About Us'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
//                $post_types = app(PosttypeInterface::class)
//                    ->findById($shortcode->post_types_id, [
//                        'post' => function ($query) use ($shortcode) {
//                            $query
//                                ->latest()
//                                ->where('status', DboardStatus::PUBLISHED)
//                                ->limit($shortcode->number_of_slide);
//                        },
//                    ]);
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.about-us', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('about-us', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.about-us-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('single-section-page', __('Single Section Page'), __('Add Single Section Page'), function ($shortcode) {
            return Theme::partial('short-codes.single-section-page', ['shortcode' => $shortcode]);
        });

        shortcode()->setAdminConfig('single-section-page', function ($attributes) {
            return Theme::partial('short-codes.single-section-page-admin-config', compact('attributes'));
        });

        add_shortcode('all-venues', __('All Venues'), __('Add All Venues'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $categories = app(CategoryInterface::class)->advancedGet([
                    'condition' => ['status' => DboardStatus::PUBLISHED],
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED);
                        },
                    ],
                ]);
//                $post_types = app(PosttypeInterface::class)->advancedGet([
//                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
//                    'take'      => 1,
//                    'with'      => [
//                        'post' => function ($query) use ($attributes) {
//                            return $query
//                                ->latest()
//                                ->where('status', DboardStatus::PUBLISHED)
//                                ->limit(Arr::get($attributes, 'number_of_slide'));
//                        },
//                    ],
//                ]);
//                dd($post_types->category);
                return Theme::partial('short-codes.all-venues', ['shortcode' => $shortcode,'categories' => $categories]);
            });
        shortcode()->setAdminConfig('all-venues', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.all-venues-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('dsc-different', __('DSC Different'), __('Add DSC Different'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.dsc-different', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('dsc-different', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.dsc-different-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('news-event', __('News And Event'), __('Add News And Event'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                $posts = $post_types->post()->orderBy('id', 'DESC')->Paginate((int)Arr::get($attributes, 'number_of_slide'));
                return Theme::partial('short-codes.news-event', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('news-event', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.news-event-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('all-news-event', __('All News And Event'), __('Add All News And Event'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->Paginate(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                $posts = $post_types->post()->orderBy('id', 'DESC')->Paginate((int)Arr::get($attributes, 'number_of_slide'));
                return Theme::partial('short-codes.all-news-event', ['shortcode' => $shortcode,'posts' => $posts]);
            });
        shortcode()->setAdminConfig('all-news-event', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.all-news-event-admin-config', compact('attributes','post_types'));
        });

        add_shortcode('our-facilities', __('Our facilities'), __('Add Our facilities'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.our-facilities', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('our-facilities', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.our-facilities-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('note-box', __('Note Box'), __('Add Note Box'),
            function ($shortcode) {
                return Theme::partial('short-codes.note-box', ['shortcode' => $shortcode]);
            });

        shortcode()->setAdminConfig('note-box', function ($attributes) {
            return Theme::partial('short-codes.note-box-admin-config', compact('attributes'));
        });

        add_shortcode('photo-gallery', __('Photo Gallery'), __('Add Photo Gallery'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.photo-gallery', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('photo-gallery', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.photo-gallery-admin-config', compact('attributes','post_types'));
        });
//        add_shortcode('banner-sections', __('Banner Sections'), __('Add Banner Sections'),
//            function ($shortcode) {
//                return Theme::partial('short-codes.banner-sections', ['shortcode' => $shortcode]);
//            });
//
//        shortcode()->setAdminConfig('banner-sections', function ($attributes) {
//            return Theme::partial('short-codes.banner-sections-admin-config', compact('attributes'));
//        });
        add_shortcode('our-partners', __('Our Partners'), __('Add Our Partners'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.our-partners', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });
        shortcode()->setAdminConfig('our-partners', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.our-partners-admin-config', compact('attributes','post_types'));
        });
//        add_shortcode('upcoming-news', __('Upcoming News'), __('Add Upcoming News'),
//            function ($shortcode) {
//                $attributes = $shortcode->toArray();
//                $category = app(PostInterface::class)->advancedGet([
//                    'condition' => [
//                        'post_types_id' => Arr::get($attributes, 'post_types_id'),
//                        'status' => DboardStatus::PUBLISHED,
//                    ],
//                    'order_by' => [
//                        'created_at' => 'DESC',
//                    ],
//                    'take'      => 1,
//                ]);
//                return Theme::partial('short-codes.upcoming-news', ['shortcode' => $shortcode,'post' => $category]);
//            });
//
//        shortcode()->setAdminConfig('upcoming-news', function ($attributes) {
//            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
//            return Theme::partial('short-codes.upcoming-news-admin-config', compact('attributes','post_types'));
//        });
//        add_shortcode('our-team', __('Our Team'), __('Add Our Team'),
//            function ($shortcode) {
//                $attributes = $shortcode->toArray();
//                $post_types = app(PosttypeInterface::class)->advancedGet([
//                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
//                    'take'      => 1,
//                    'with'      => [
//                        'post' => function ($query) use ($attributes) {
//                            return $query
//                                ->latest()
//                                ->where('status', DboardStatus::PUBLISHED)
//                                ->limit(Arr::get($attributes, 'number_of_slide'));
//                        },
//                    ],
//                ]);
//                return Theme::partial('short-codes.our-team', ['shortcode' => $shortcode,'post_types' => $post_types]);
//            });
//        shortcode()->setAdminConfig('our-team', function ($attributes) {
//            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
//            return Theme::partial('short-codes.our-team-admin-config', compact('attributes','post_types'));
//        });
        add_shortcode('testimonial', __('Testimonial'), __('Add Testimonial'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.testimonial', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });

        shortcode()->setAdminConfig('testimonial', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.testimonial-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('testimonial-all', __('Testimonial All'), __('Add Testimonial All'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.testimonial-all', ['shortcode' => $shortcode,'posts' => $post_types->post()->paginate((int)Arr::get($attributes, 'number_of_slide'))]);
            });

        shortcode()->setAdminConfig('testimonial-all', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.testimonial-all-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('partners', __('Partners'), __('Add Partners'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $post_types = app(PosttypeInterface::class)->advancedGet([
                    'condition' => ['post_types.id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 1,
                    'with'      => [
                        'post' => function ($query) use ($attributes) {
                            return $query
                                ->latest()
                                ->where('status', DboardStatus::PUBLISHED)
                                ->limit(Arr::get($attributes, 'number_of_slide'));
                        },
                    ],
                ]);
                return Theme::partial('short-codes.partners', ['shortcode' => $shortcode,'post_types' => $post_types]);
            });

        shortcode()->setAdminConfig('partners', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.partners-admin-config', compact('attributes','post_types'));
        });
        add_shortcode('resources-news', __('Resources News'), __('Add Resources News'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $category = app(PostInterface::class)->advancedGet([
                    'condition' => ['post_types_id' => Arr::get($attributes, 'post_types_id')],
                    'take'      => 3,
                ]);
                return Theme::partial('short-codes.resources-news', ['shortcode' => $shortcode,'posts' => $category]);
        });
        shortcode()->setAdminConfig('resources-news', function ($attributes) {
            $post_types = app(PosttypeInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.resources-news-admin-config', compact('attributes','post_types'));
        });

        add_shortcode('faq-option', __('Our FAQ Option'), __('Add FAQ Option'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $faqs = app(FaqInterface::class)->advancedGet([
                    'condition' => ['category_id' => Arr::get($attributes, 'category_id')],
//                    'take'      => 1,
//                    'with'      => [
//                        'faqs' => function ($query) {
//                            return $query
//                                ->latest()
//                                ->where('status', DboardStatus::PUBLISHED);
//                        },
//                    ],
                ]);
                return Theme::partial('short-codes.faq-option', ['title' => $shortcode->title,'image' => $shortcode->image,'faqs' => $faqs]);
            });

        shortcode()->setAdminConfig('faq-option', function ($attributes) {
            $categories = app(FaqCategoryInterface::class)->allBy(['status' => Dboardstatus::PUBLISHED]);
            return Theme::partial('short-codes.faq-option-admin-config', compact('attributes','categories'));
        });
        add_shortcode('contact-us', __('Contact Us'), __('Add Contact Us'),
            function ($shortcode) {
                $attributes = $shortcode->toArray();
                $contact = app(MentorInterface::class)->advancedGet([
                    'condition' => ['status' => DboardStatus::PUBLISHED],
//                    'take'      => 1,
//                    'paginate'  => [
//                        'per_page'      => Arr::get($attributes, 'number_of_course'),
//                        'current_paged' => 1,
//                    ],
                    'with'      => ['slugable'],
                ]);
                return Theme::partial('short-codes.contact-us', ['title' => $shortcode->title,'image' => $shortcode->image,'contact' => $contact]);
            });
        shortcode()->setAdminConfig('contact-us', function ($attributes) {
            return Theme::partial('short-codes.contact-us-admin-config', compact('attributes'));
        });
    }
});
