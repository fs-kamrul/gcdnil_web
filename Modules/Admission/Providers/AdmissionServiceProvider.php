<?php

namespace Modules\Admission\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Admission\Packages\Facades\AdmissionoptionFacade;
use Theme;

class AdmissionServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Admission';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'admission';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        if (function_exists('add_shortcode')) {
            add_shortcode(
                'admission-form',
                trans('admission::lang.shortcode_name'),
                trans('admission::lang.shortcode_description'),
                [$this, 'form']
            );

            shortcode()
                ->setAdminConfig('admission-form', function ($attributes) {
                    return view('admission::partials.short-code-admin-config', compact('attributes'))->render();
                });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        AliasLoader::getInstance()->alias('Admissionoption', AdmissionoptionFacade::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
    /**
     * @return string
     * @throws \Throwable
     */
    public function form($shortcode)
    {
        $view = apply_filters(ADMISSION_FORM_TEMPLATE_VIEW, 'admission::forms.contact');

        if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $this->app->booted(function () {
                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('location-js', url('vendor/Modules/Location/js/location.js'), [], [], '1.0.0');
                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('location-js', url('vendor/Modules/Option/js/option_set_subject.js'), [], [], '1.0.0');
//                    ->add('location-js', url('/js/location.js'), [], [], '1.0.0');
//                Assets::addScriptsDirectly([
//                    'vendor/Modules/Location/js/location.js',
//                ]);
//                Theme::asset()
//                    ->usePath(false)
//                    ->add('contact-css', url('vendor/contact/css/contact-public.css'), [], [], '1.0.0');
//
//                Theme::asset()
//                    ->container('footer')
//                    ->usePath(false)
//                    ->add('contact-public-js', url('vendor/contact/js/contact-public.js'),
//                        ['jquery'], [], '1.0.0');
            });
        }

        if ($shortcode->view && view()->exists($shortcode->view)) {
            $view = $shortcode->view;
        }

        return view($view, compact('shortcode'))->render();
    }
}
