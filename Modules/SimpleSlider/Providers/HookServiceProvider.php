<?php

namespace Modules\SimpleSlider\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Shortcodes\Compilers\Shortcode;
use Modules\SimpleSlider\Http\Models\SimpleSlider;
use Modules\SimpleSlider\Http\Models\SimpleSliderItem;
use Modules\SimpleSlider\Repositories\Cache\SimpleSliderCacheDecorator;
use Modules\SimpleSlider\Repositories\Cache\SimpleSliderItemCacheDecorator;
use Modules\SimpleSlider\Repositories\Eloquent\SimpleSliderItemRepository;
use Modules\SimpleSlider\Repositories\Eloquent\SimpleSliderRepository;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Theme;

//add_new_line_Interface_and_Repository_call

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(SimpleSliderInterface::class, function () {
            return new SimpleSliderCacheDecorator(
                new SimpleSliderRepository(new SimpleSlider)
            );
        });
        $this->app->bind(SimpleSliderItemInterface::class, function () {
            return new SimpleSliderItemCacheDecorator(new SimpleSliderItemRepository(new SimpleSliderItem));
        });
//add_new_line_Interface_and_Repository_to_hook

        if (function_exists('shortcode')) {
            add_shortcode(
                'simple-slider',
                trans('simpleslider::simple-slider.simple_slider_shortcode_name'),
                trans('simpleslider::simple-slider.simple_slider_shortcode_description'),
                [$this, 'render']
            );

            shortcode()->setAdminConfig('simple-slider', function ($attributes) {
                $sliders = $this->app->make(SimpleSliderInterface::class)
                    ->pluck('name', 'key', ['status' => DboardStatus::PUBLISHED]);

                return view('simpleslider::partials.simple-slider-admin-config', compact('sliders', 'attributes'))
                    ->render();
            });
        }

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 301);

//        Form::component('slider-items', 'contactform::reply-box', [
//            'title' => trans('simpleslider::simple-slider.slide_items'),
//            'contact' => null,
//        ]);
    }

    public function render(Shortcode $shortcode)
    {
        $slider = $this->app->make(SimpleSliderInterface::class)->getFirstBy([
            'key' => $shortcode->key,
            'status' => DboardStatus::PUBLISHED,
        ]);

        if (empty($slider)) {
            return null;
        }

        if (setting('simple_slider_using_assets', true) && defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $version = '1.0.1';
            $dist = asset('vendor/Modules/SimpleSlider');

            Theme::asset()
                ->container('footer')
                ->usePath(false)
                ->add('simple-slider-owl-carousel-css', $dist . '/lib/owl-carousel/owl.carousel.css', [], [], $version)
                ->add('simple-slider-css', $dist . '/css/simple-slider.css', [], [], $version)
                ->add('simple-slider-owl-carousel-js', $dist . '/lib/owl-carousel/owl.carousel.js', ['jquery'], [], $version)
                ->add('simple-slider-js', $dist . '/js/simple-slider.js', ['jquery'], [], $version);
        }

        return view(apply_filters(SIMPLE_SLIDER_VIEW_TEMPLATE, 'simpleslider::sliders'), [
            'sliders' => $slider->sliderItems,
            'shortcode' => $shortcode,
            'slider' => $slider,
        ]);
    }

    public function addSettings(?string $data = null): string
    {
        return $data . view('simpleslider::setting')->render();
    }
}
