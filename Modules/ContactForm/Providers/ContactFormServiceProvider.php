<?php

namespace Modules\ContactForm\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\ContactForm\Http\Models\ContactForm;
use Modules\ContactForm\Http\Models\ContactFormReplie;
use Modules\ContactForm\Repositories\Caches\ContactCacheDecorator;
use Modules\ContactForm\Repositories\Caches\ContactReplyCacheDecorator;
use Modules\ContactForm\Repositories\Eloquent\ContactReplyRepository;
use Modules\ContactForm\Repositories\Eloquent\ContactRepository;
use Modules\ContactForm\Repositories\Interfaces\ContactInterface;
use Modules\ContactForm\Repositories\Interfaces\ContactReplyInterface;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Theme;
use EmailHandler;

class ContactFormServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'ContactForm';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'contactform';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['email'])
            ->loadHelpers()
            ->publishAssets();


        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
//        $this->add_shortcode();

        EmailHandler::addTemplateSettings(CONTACT_MODULE_SCREEN_NAME_MAIL, config('Modules.ContactForm.email', []));

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactCacheDecorator(new ContactRepository(new ContactForm));
        });
        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyCacheDecorator(new ContactReplyRepository(new ContactFormReplie));
        });

        $this->app->register(RouteServiceProvider::class);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function add_shortcode()
    {
        if (function_exists('add_shortcode')) {
            add_shortcode('contact-form', trans('contactform::lang.shortcode_name'), trans('contactform::lang.shortcode_description'), [$this, 'form']);
            shortcode()
                ->setAdminConfig('contact-form', view('contactform::partials.short-code-admin-config')->render());
        }
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
        $view = apply_filters(CONTACT_FORM_TEMPLATE_VIEW, 'contactform::forms.contact');

        if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $this->app->booted(function () {
                Theme::asset()
                    ->usePath(false)
                    ->add('contact-css', url('vendor/contact/css/contact-public.css'), [], [], '1.0.0');

                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('contact-public-js', url('vendor/contact/js/contact-public.js'),
                        ['jquery'], [], '1.0.0');
            });
        }

        if ($shortcode->view && view()->exists($shortcode->view)) {
            $view = $shortcode->view;
        }

        return view($view)->render();
    }
}
