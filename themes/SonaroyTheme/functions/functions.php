<?php
//
//if (is_module_active('Widget')) {
//    register_sidebar([
//        'id' => 'footer_sidebar',
//        'name' => __('Footer sidebar'),
//        'description' => __('Sidebar in the footer of page'),
//    ]);
//}
//
use Modules\Mentor\Repositories\Interfaces\MentorInterface;
use Modules\SimpleSlider\Http\Models\SimpleSlider;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\VenueFacility\Repositories\Interfaces\KeyFacilityInterface;
use Modules\SimpleSlider\Http\Models\SimpleSliderItem;

if (!function_exists('get_blog_layouts')) {
    /**
     * @return string[]
     */
    function get_blog_layouts(): array
    {
        return [
            'grid' => __('Grid layout'),
            'list' => __('List layout'),
            'big'  => __('Big layout'),
        ];
    }
}
?>
<?php

//use Modules\Ads\Http\Models\Ads;
use Modules\KamrulDashboard\Forms\FormAbstract;
use Modules\KamrulDashboard\Http\Models\MetaBox as MetaBoxModel;
use Modules\Post\Http\Models\Post;
use Modules\Ecommerce\Http\Models\EcommerceFlashSale;
use Modules\Ecommerce\Http\Models\EcommerceProduct;
use Modules\Ecommerce\Http\Models\EcommerceProductCategory;
use Modules\LanguageAdvanced\Packages\Supports\LanguageAdvancedManager;
use Modules\Post\Http\Models\Page;
//use Modules\SimpleSlider\Models\SimpleSlider;
//use Modules\SimpleSlider\Models\SimpleSliderItem;
//use Theme\HrdiTheme\Fields\ThemeIconField;

register_page_template([
    'full-width' => __('Full width'),
    'homepage' => __('Homepage'),
    'post-right-sidebar' => __('Blog Right Sidebar'),
    'post-left-sidebar' => __('Blog Left Sidebar'),
    'post-full-width' => __('Blog Full Width'),
]);

register_sidebar([
    'id' => 'footer_sidebar',
    'name' => __('Footer sidebar'),
    'description' => __('Widgets in footer of page'),
]);

register_sidebar([
    'id' => 'product_sidebar',
    'name' => __('Product sidebar'),
    'description' => __('Widgets in the product page'),
]);

Form::component('themeIcon', Theme::getThemeNamespace() . '::partials.forms.fields.icons-field', [
    'name',
    'value' => null,
    'attributes' => [],
]);

//add_filter('form_custom_fields', function (FormAbstract $form, FormHelper $formHelper) {
//    if (! $formHelper->hasCustomField('themeIcon')) {
//        $form->addCustomField('themeIcon', ThemeIconField::class);
//    }
//
//    return $form;
//}, 29, 2);

if (is_module_active('Ecommerce')) {
    app()->booted(function () {
        EcommerceProductCategory::resolveRelationUsing('icon', function ($model) {
            return $model->morphOne(MetaBoxModel::class, 'reference')->where('meta_key', 'icon');
        });

        if (is_module_active('LanguageAdvanced')) {
            LanguageAdvancedManager::registerModule(EcommerceFlashSale::class, ['name', 'subtitle']);
        }
    });
}

if (! function_exists('get_currencies_json')) {
    /**
     * @return array
     */
    function get_currencies_json()
    {
        $currency = get_application_currency();
        $numberAfterDot = $currency->decimals ?: 0;

        return [
            'display_big_money' => config('ecommerce.display_big_money_in_million_billion'),
            'billion' => __('billion'),
            'million' => __('million'),
            'is_prefix_symbol' => $currency->is_prefix_symbol,
            'symbol' => $currency->symbol,
            'title' => $currency->title,
            'decimal_separator' => get_ecommerce_setting('decimal_separator', '.'),
            'thousands_separator' => get_ecommerce_setting('thousands_separator', ','),
            'number_after_dot' => $numberAfterDot,
            'show_symbol_or_title' => true,
        ];
    }
}

if (! function_exists('get_blog_single_layouts')) {
    /**
     * @return string[]
     */
    function get_blog_single_layouts(): array
    {
        return [
            '' => __('Inherit'),
            'post-right-sidebar' => __('Right Sidebar'),
            'post-left-sidebar' => __('Left Sidebar'),
            'post-full-width' => __('Full width'),
        ];
    }
}

if (! function_exists('get_product_single_layouts')) {
    /**
     * @return string[]
     */
    function get_product_single_layouts(): array
    {
        return [
            '' => __('Inherit'),
            'product-right-sidebar' => __('Right Sidebar'),
            'product-left-sidebar' => __('Left Sidebar'),
            'product-full-width' => __('Full Width'),
        ];
    }
}
if (! function_exists('get_section_type_layouts')) {
    /**
     * @return string[]
     */
    function get_section_type_layouts(): array
    {
        return [
                'none' => __('None'),
                'why_dsc' => __('Why DSC'),
                'video_view' => __('Video View'),
            ];
    }
}
if (! function_exists('get_product_mentors')) {
    /**
     * @return string[]
     */
    function get_product_mentors(): array
    {
        $data =  app(MentorInterface::class)->pluck('name','id');
        return $data;
    }
}
if (! function_exists('get_meta_dsc_addition')) {
    /**
     * @param Post $post
     * @return string
     */
    function get_meta_dsc_addition(Post $post, $data = 'kamrul')
    {
//        $data = null;
//        $venuefacility = array();
        $venuefacility[$data] = null;
        $venuefacility = MetaBox::getMetaData($post, 'dsc_addition', true);
//        return $venuefacility;
        if($venuefacility) {
            return $venuefacility[$data];
        }else{
            return null;
        }
    }
}
if (! function_exists('get_venuefacility')) {
    /**
     * @return string[]
     */
    function get_venuefacility(): array
    {
        $data =  app(\Modules\VenueFacility\Repositories\Interfaces\VenueFacilityInterface::class)
            ->pluck('name','id',['status' => DboardStatus::PUBLISHED]);
        return $data;
    }
}
if (! function_exists('get_meta_venuefacility')) {
    /**
     * @param Post $post
     * @return string
     */
    function get_meta_venuefacility(Post $post)
    {
        $data = [];
        $venuefacility = MetaBox::getMetaData($post, 'venuefacility', true);
        if($venuefacility) {
            $data = app(\Modules\VenueFacility\Repositories\Interfaces\VenueFacilityInterface::class)
                ->getByWhereIn('id', $venuefacility);
        }
        return $data;
    }
}
if (! function_exists('get_keyfacility')) {
    /**
     * @return string[]
     */
    function get_keyfacility(): array
    {
        $data =  app(KeyFacilityInterface::class)
            ->pluck('name','id',['status' => DboardStatus::PUBLISHED]);
        return $data;
    }
}

if (! function_exists('get_meta_keyfacility')) {
    /**
     * @param Post $post
     * @return string
     */
    function get_meta_keyfacility(Post $post)
    {
        $data = [];
        $keyfacility = MetaBox::getMetaData($post, 'keyfacility', true);
        if($keyfacility) {
            $data = app(KeyFacilityInterface::class)
                ->getByWhereIn('id', $keyfacility);
        }
        return $data;
    }
}

if (! function_exists('get_layout_header_styles')) {
    /**
     * @return string[]
     */
    function get_layout_header_styles(): array
    {
        return [
            'header-style-1' => __('Default'),
            'header-style-2' => __('Header style 2'),
            'header-style-3' => __('Header style 3'),
            'header-style-4' => __('Header style 4'),
        ];
    }
}

if (! function_exists('get_simple_slider_styles')) {
    /**
     * @return string[]
     */
    function get_simple_slider_styles(): array
    {
        return [
            'style-1' => __('Default - Full width'),
            'style-2' => __('Full width - text center'),
//            'style-3' => __('With Ads'),
            'style-4' => __('Limit width'),
        ];
    }
}

if (! function_exists('get_time_to_read')) {
    /**
     * @param Post $post
     * @return string
     */
    function get_time_to_read(Post $post)
    {
        $timeToRead = MetaBox::getMetaData($post, 'time_to_read', true);

        if ($timeToRead) {
            return number_format($timeToRead);
        }

        return number_format(strlen(strip_tags($post->content)) / 300);
    }
}

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
    switch (get_class($data)) {
//        case SimpleSliderItem::class:
//            $buttonText = MetaBox::getMetaData($data, 'button_text', true);
//            $subtitle = MetaBox::getMetaData($data, 'subtitle', true);
//            $highlightText = MetaBox::getMetaData($data, 'highlight_text', true);
//
//            $form
//                ->addAfter('link', 'button_text', 'text', [
//                    'label' => __('Button text'),
//                    'label_attr' => ['class' => 'control-label'],
//                    'value' => $buttonText,
//                    'attr' => [
//                        'placeholder' => __('Ex: Shop now'),
//                    ],
//                ])
//                ->addBefore('title', 'subtitle', 'text', [
//                    'label' => __('Subtitle'),
//                    'label_attr' => ['class' => 'control-label'],
//                    'value' => $subtitle,
//                    'attr' => [
//                        'placeholder' => __('Text to highlight'),
//                    ],
//                ])
//                ->addAfter('title', 'highlight_text', 'text', [
//                    'label' => __('Highlight text'),
//                    'label_attr' => ['class' => 'control-label'],
//                    'value' => $highlightText,
//                    'attr' => [
//                        'placeholder' => __('Text to highlight'),
//                    ],
//                ]);
//
//            break;

//        case Ads::class:
//            $buttonText = MetaBox::getMetaData($data, 'button_text', true);
//            $subtitle = MetaBox::getMetaData($data, 'subtitle', true);
//
//            $form
//                ->addAfter('key', 'button_text', 'text', [
//                    'label' => __('Button text'),
//                    'label_attr' => ['class' => 'control-label'],
//                    'value' => $buttonText,
//                    'attr' => [
//                        'placeholder' => __('Ex: Shop now'),
//                    ],
//                ])
//                ->addBefore('key', 'subtitle', 'textarea', [
//                    'label' => __('Subtitle'),
//                    'label_attr' => ['class' => 'control-label'],
//                    'value' => $subtitle,
//                    'attr' => [
//                        'placeholder' => __('Text to highlight'),
//                        'rows' => 3,
//                    ],
//                ])
//                ->setBreakFieldPoint('image');
//
//            break;

        case EcommerceFlashSale::class:
            $subtitle = MetaBox::getMetaData($data, 'subtitle', true);
            $image = MetaBox::getMetaData($data, 'image', true);

            $form
                ->addAfter('name', 'subtitle', 'text', [
                    'label' => __('Subtitle'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $subtitle,
                    'attr' => [
                        'placeholder' => __('Text to highlight'),
                    ],
                ])
                ->addAfter('end_date', 'image', 'mediaImage', [
                    'label' => __('Image'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $image,
                ]);

            break;
    }

    return $form;
}, 124, 3);

add_action(BASE_ACTION_META_BOXES, function ($context, $object) {
    switch (get_class($object)) {

        case SimpleSlider::class:
            if ($context == 'top') {
                MetaBox::addMetaBox(
                    'additional_simple_slider_fields',
                    __('Appearance'),
                    function () {
                        $style = '';
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $style = MetaBox::getMetaData($args[0], 'simple_slider_style', true);
                        }

                        return Theme::partial('additional-simple-slider-fields', compact('style'));
                    },
                    get_class($object),
                    $context
                );
            }

            break;

        case SimpleSliderItem::class:
            if ($context == 'top') {
                MetaBox::addMetaBox(
                    'subtitle',
                    __('Subtitle'),
                    function () {
                        $style = '';
                        $name = 'subtitle';
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $style = MetaBox::getMetaData($args[0], 'subtitle', true);
                        }

                        return Theme::partial('additional-simple-slider-items-fields', compact('style', 'name'));
                    },
                    get_class($object),
                    $context
                );
                MetaBox::addMetaBox(
                    'highlight_text',
                    __('Highlight text'),
                    function () {
                        $style = '';
                        $name = 'highlight_text';
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $style = MetaBox::getMetaData($args[0], 'highlight_text', true);
                        }

                        return Theme::partial('additional-simple-slider-items-fields', compact('style', 'name'));
                    },
                    get_class($object),
                    $context
                );
            }
            if ($context == 'advanced') {
                MetaBox::addMetaBox(
                    'button_text',
                    __('Button Show'),
                    function () {
                        $style = '';
                        $name = 'button_text';
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $style = MetaBox::getMetaData($args[0], 'button_text', true);
                        }

                        return Theme::partial('additional-simple-slider-items-fields', compact('style', 'name'));
                    },
                    get_class($object),
                    $context
                );
            }

            break;

        case EcommerceProductCategory::class:
            if ($context == 'advanced') {
                MetaBox::addMetaBox('additional_product_category_fields', __('Addition Information'), function () {
                    $icon = null;
                    $iconImage = null;
                    $args = func_get_args();
                    if (! empty($args[0])) {
                        $icon = MetaBox::getMetaData($args[0], 'icon', true);
                        $iconImage = MetaBox::getMetaData($args[0], 'icon_image', true);
                    }

                    return Theme::partial('product-category-fields', compact('icon', 'iconImage'));
                }, get_class($object), $context);
            }

            break;

        case EcommerceProduct::class:
            if ($context == 'top') {
                MetaBox::addMetaBox(
                    'additional_product_fields',
                    __('Addition Information'),
                    function () {
                        $layout = null;
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $layout = MetaBox::getMetaData($args[0], 'layout', true);
                        }

                        if (! $layout && theme_option('product_single_layout')) {
                            $layout = theme_option('product_single_layout');
                        }

                        return Theme::partial('additional-product-fields', compact('layout'));
                    },
                    get_class($object),
                    $context
                );
                MetaBox::addMetaBox(
                    'additional_product_mentors',
                    __('Mentor'),
                    function () {
                        $mentor = null;
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $mentor = MetaBox::getMetaData($args[0], 'mentor', true);
                        }

//                        if (! $mentor && theme_option('product_single_layout')) {
//                            $mentor = theme_option('product_single_layout');
//                        }

                        return Theme::partial('additional-product-mentors', compact('mentor'));
                    },
                    get_class($object),
                    $context
                );
            }

            break;

        case Post::class:
            if ($context == 'top') {
                MetaBox::addMetaBox(
                    'additional_post_fields',
                    __('Addition Information'),
                    function () {
                        $layout = null;
                        $args = func_get_args();
                        if (! empty($args[0])) {
                            $layout = MetaBox::getMetaData($args[0], 'layout', true);
                        }

//                        if (! $layout && theme_option('product_single_layout')) {
//                            $layout = theme_option('product_single_layout');
//                        }

                        return Theme::partial('additional-post-fields', compact('layout'));
                    },
                    get_class($object),
                    $context
                );
            }
            if (is_module_active('VenueFacility')) {
                if ($context == 'top') {
                    MetaBox::addMetaBox(
                        'additional_venuefacility',
                        __('Facility'),
                        function () {
                            $venuefacility = [];
                            $args = func_get_args();
                            if (! empty($args[0])) {
                                $venuefacility = MetaBox::getMetaData($args[0], 'venuefacility', true);
                            }
                            return Theme::partial('additional-venuefacility', compact('venuefacility'));
                        },
                        get_class($object),
                        $context
                    );
                    MetaBox::addMetaBox(
                        'additional_keyfacility',
                        __('Key Facility'),
                        function () {
                            $keyfacility = [];
                            $args = func_get_args();
                            if (! empty($args[0])) {
                                $keyfacility = MetaBox::getMetaData($args[0], 'keyfacility', true);
                            }
                            return Theme::partial('additional-keyfacility', compact('keyfacility'));
                        },
                        get_class($object),
                        $context
                    );
                }
            }

            break;
    }
}, 75, 2);

add_action([BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT], function ($type, $request, $object) {
    switch (get_class($object)) {
        case SimpleSlider::class:
            if ($request->has('simple_slider_style')) {
                $style = $request->input('simple_slider_style');

                if (in_array($style, array_keys(get_simple_slider_styles()))) {
                    MetaBox::saveMetaBoxData($object, 'simple_slider_style', $style);
                }
            }

            break;

        case SimpleSliderItem::class:
            if ($request->has('button_text')) {
                MetaBox::saveMetaBoxData($object, 'button_text', $request->input('button_text'));
            }

            if ($request->has('subtitle')) {
                MetaBox::saveMetaBoxData($object, 'subtitle', $request->input('subtitle'));
            }

            if ($request->has('highlight_text')) {
                MetaBox::saveMetaBoxData($object, 'highlight_text', $request->input('highlight_text'));
            }

            break;

        case EcommerceProductCategory::class:

            if ($request->has('icon')) {
                MetaBox::saveMetaBoxData($object, 'icon', $request->input('icon'));
            }

            if ($request->has('icon_image')) {
                MetaBox::saveMetaBoxData($object, 'icon_image', $request->input('icon_image'));
            }

            break;

        case EcommerceProduct::class:
            if ($request->has('layout')) {
                MetaBox::saveMetaBoxData($object, 'layout', $request->input('layout'));
            }
            if ($request->has('mentor')) {
                MetaBox::saveMetaBoxData($object, 'mentor', $request->input('mentor'));
            }

            break;

        case Post::class:
//            dd($request->has('additional_post_fields'));
            if ($request->has('layout')) {
                MetaBox::saveMetaBoxData($object, 'layout', $request->input('layout'));
            }
            if (is_module_active('VenueFacility')) {
                if ($request->has('dsc_addition')) {
                    MetaBox::saveMetaBoxData($object, 'dsc_addition', $request->input('dsc_addition'));
                }
            }
            if ($request->has('venuefacility')) {
                MetaBox::saveMetaBoxData($object, 'venuefacility', $request->input('venuefacility'));
            }
            if ($request->has('keyfacility')) {
                MetaBox::saveMetaBoxData($object, 'keyfacility', $request->input('keyfacility'));
            }

            break;

        case EcommerceFlashSale::class:
            if ($request->has('subtitle')) {
                MetaBox::saveMetaBoxData($object, 'subtitle', $request->input('subtitle'));
            }

            if ($request->has('image')) {
                MetaBox::saveMetaBoxData($object, 'image', $request->input('image'));
            }

            break;

//        case Ads::class:
//            if ($request->has('button_text')) {
//                MetaBox::saveMetaBoxData($object, 'button_text', $request->input('button_text'));
//            }
//
//            if ($request->has('subtitle')) {
//                MetaBox::saveMetaBoxData($object, 'subtitle', $request->input('subtitle'));
//            }
//
//            break;
    }
}, 75, 3);

if (! function_exists('theme_get_autoplay_speed_options')) {
    /**
     * @return int[]
     */
    function theme_get_autoplay_speed_options(): array
    {
        return array_combine([2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000], [2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]);
    }
}

//app()->booted(function () {
//    if (is_module_active('ads') && is_module_active('LanguageAdvanced')) {
//        LanguageAdvancedManager::registerModule(Ads::class, [
//            'name',
//            'image',
//            'url',
//            'subtitle',
//            'button_text',
//        ]);
//    }
//});

register_sidebar([
    'id' => 'top_footer_sidebar',
    'name' => __('Top footer sidebar'),
    'description' => __('Widgets in the footer of page'),
]);

