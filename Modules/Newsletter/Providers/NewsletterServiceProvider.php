<?php

namespace Modules\Newsletter\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Newsletter as MailchimpNewsletter;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Events\RouteMatched;
use Exception;
use SendGrid;
use EmailHandler;

class NewsletterServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Newsletter';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'newsletter';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadHelpers()
            ->loadAndPublishConfigurations(['email'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews();

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->register(EventServiceProvider::class);
        EmailHandler::addTemplateSettings(NEWSLETTER_MODULE_SCREEN_NAME, config('Modules.Newsletter.email', []));

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 249);
    }

    public function addSettings($data = null): string
    {
        $mailchimpContactList = [];
        $mailchimpApiKey = setting('newsletter_mailchimp_api_key');

        if ($mailchimpApiKey) {
            try {
                $list = MailchimpNewsletter::getApi()->get('lists');

                $results = Arr::get($list, 'lists');

                if (! setting('newsletter_mailchimp_list_id')) {
                    setting()->set(['newsletter_mailchimp_list_id' => Arr::first($results, 'id')])->save();
                }

                foreach ($results as $result) {
                    $mailchimpContactList[$result['id']] = $result['name'];
                }
            } catch (Exception $exception) {
                info('Caught exception: ' . $exception->getMessage());
            }
        }

        $sendGridContactList = [];

        $sendgridApiKey = setting('newsletter_sendgrid_api_key');
        if ($sendgridApiKey) {
            $sg = new SendGrid($sendgridApiKey);

            try {
                $list = $sg->client->marketing()->lists()->get();

                $results = Arr::get(json_decode($list->body(), true), 'result');

                if (! setting('newsletter_sendgrid_list_id')) {
                    setting()->set(['newsletter_sendgrid_list_id' => Arr::first($results, 'id')])->save();
                }

                foreach ($results as $result) {
                    $sendGridContactList[$result['id']] = $result['name'];
                }
            } catch (Exception $exception) {
                info('Caught exception: ' . $exception->getMessage());
            }
        }

        return $data . view('newsletter::setting', compact('mailchimpContactList', 'sendGridContactList'))
                ->render();
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
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
}
