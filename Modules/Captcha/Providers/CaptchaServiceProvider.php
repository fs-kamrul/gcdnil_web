<?php

namespace Modules\Captcha\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Captcha\Facades\CaptchaFacade;
use Modules\Captcha\Supports\Captcha;
use Modules\Captcha\Supports\CaptchaV3;
use Modules\Captcha\Supports\MathCaptcha;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Theme;

class CaptchaServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Captcha';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'captcha';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
//            ->loadAndPublishConfigurations(['config'])
            ->loadAndPublishViews()
//            ->publishAssets()
            ->loadHelpers();

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->bootValidator();

        if (defined('THEME_MODULE_SCREEN_NAME') && setting('captcha_hide_badge')) {
            Theme::asset()->writeStyle('hide-recaptcha-badge', '.grecaptcha-badge { visibility: hidden; }');
        }

//        config([
//            'captcha.secret' => setting('captcha_secret'),
//            'captcha.site_key' => setting('captcha_site_key'),
//            'captcha.type' => setting('captcha_type'),
//        ]);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

//        dd(config());
//        config([
//            'captcha.secret' => setting('captcha_secret'),
////            'captcha.secret' => SettingDataF::get('captcha_secret', null)(),
//            'captcha.site_key' => setting('captcha_site_key'),
//            'captcha.type' => setting('captcha_type'),
//        ]);
        $this->app->singleton('captcha', function () {
//            dd(setting('captcha_type'));
            if (setting('captcha_type') === 'v3') {
                return new CaptchaV3(setting('captcha_site_key'), setting('captcha_secret'));
            }
            return new Captcha(setting('captcha_site_key'), setting('captcha_secret'));
        });

        $this->app->singleton('math-captcha', function ($app) {
            return new MathCaptcha($app['session']);
        });

        AliasLoader::getInstance()->alias('Captcha', CaptchaFacade::class);
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
     * Create captcha validator rule
     */
    public function bootValidator()
    {
        $app = $this->app;

        /**
         * @var Validator $validator
         */
        $validator = $app['validator'];
        $validator->extend('captcha', function ($attribute, $value, $parameters) use ($app) {
            if (setting('captcha_type') === 'v3') {
                if (empty($parameters)) {
                    $parameters = ['form', '0.6'];
                }
            } else {
                $parameters = $this->mapParameterToOptions($parameters);
            }

            return $app['captcha']->verify((string)$value, $this->app['request']->getClientIp(), $parameters);
        }, __('Captcha Verification Failed!'));

        $validator->extend('math_captcha', function ($attribute, $value) {
            return $this->app['math-captcha']->verify((string)$value);
        }, __('Math Captcha Verification Failed!'));
    }

    public function mapParameterToOptions(array $parameters = []): array
    {
        if (! is_array($parameters)) {
            return [];
        }

        $options = [];

        foreach ($parameters as $parameter) {
            $option = explode(':', $parameter);
            if (count($option) === 2) {
                Arr::set($options, $option[0], $option[1]);
            }
        }

        return $options;
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['captcha', 'math-captcha'];
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
}
