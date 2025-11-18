<?php

namespace Modules\KamrulDashboard\Providers;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\KamrulDashboard\Hooks\EmailSettingHooks;
use Modules\KamrulDashboard\Http\Middleware\DboardMiddleware;
use Modules\KamrulDashboard\Http\Middleware\DisableInDemoModeMiddleware;
use Modules\KamrulDashboard\Http\Middleware\KamrulMiddleware;
use Modules\KamrulDashboard\Http\Models\DashboardWidget;
use Modules\KamrulDashboard\Http\Models\DashboardWidgetSetting;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\MetaBox  as MetaBoxModel;;
use Modules\KamrulDashboard\Http\Models\Permission;
use Modules\KamrulDashboard\Http\Models\Role;
use Modules\KamrulDashboard\Http\Models\Setting;
use Modules\KamrulDashboard\Http\Models\SettingData;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Models\User;
use DateTimeZone;
use MetaBox;
use Modules\KamrulDashboard\Packages\Facades\DboardMediaFacade;
use Modules\KamrulDashboard\Packages\Facades\SettingFacade;
use Modules\KamrulDashboard\Packages\Supports\Action;
use Modules\KamrulDashboard\Packages\Supports\Chunks\Storage\ChunkStorage;
use Modules\KamrulDashboard\Packages\Supports\CustomResourceRegistrar;
use Modules\KamrulDashboard\Packages\Supports\Filter;
use Modules\KamrulDashboard\Packages\Supports\SettingsManager;
use Modules\KamrulDashboard\Packages\Supports\SettingStore;
use Modules\KamrulDashboard\Packages\Supports\SlugHelper;
use Modules\KamrulDashboard\Repositories\Eloquent\DashboardWidgetRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\DashboardWidgetSettingRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\MetaBoxRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\PermissionRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\RoleRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\SettingRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\SettingrowRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\SlugRepository;
use Modules\KamrulDashboard\Repositories\Eloquent\UserRepository;
use Modules\KamrulDashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\MetaBoxInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\PermissionInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\RoleInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\SettingInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\SettingrowInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\SlugInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\UserInterface;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\Facades\Config;
use MacroableModels;
use DboardHelper;
use EmailHandler;
use DboardMedia;
use Modules\KamrulDashboard\Widgets\AdminWidget;
use Modules\KamrulDashboard\Widgets\Contracts\AdminWidget as AdminWidgetContract;
use Modules\Post\Http\Models\Page;

class KamrulDashboardServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'KamrulDashboard';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'kamruldashboard';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
//            ->loadAnonymousComponents()
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadAndPublishConfigurations(['assets','media','email'])
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->registerTranslations();
        $this->registerCssPublish();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

//        dd(config('Modules.KamrulDashboard.email', []));
        EmailHandler::addTemplateSettings(KAMRULDASHBOARD_MODULE_SCREEN_NAME, config('Modules.KamrulDashboard.email', []));

        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->aliasMiddleware('preventDemo', DisableInDemoModeMiddleware::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(SlugEventServiceProvider::class);

        $config = $this->app->make('config');
        $setting = $this->app->make(SettingStore::class);
        $config->set([
            'filesystems.default' => $setting->get('media_driver', 'public'),
            'filesystems.disks.public.root' => public_path('uploads'),
            'filesystems.disks.public.url' => env('APP_URL').'/public/uploads',
        ]);

        Gate::before(function ($user, $ability) {
//            ['backup','manage_plugins']
//            $administrator_list = config('kamruldashboard.administrator_usernames');
            $administrator_list = env('ADMINISTRATOR_USERNAMES','kamrul');
            if (in_array($user->username, explode(',', $administrator_list))) {
                return true;
            }elseif (in_array($ability, hasRole($user->id))) {
                return true;
            }else{
                return false;
            }
        });
        $config = $this->app->make('config');
        if ($this->app->environment('local') || $config->get('kamruldashboard.disable_verify_csrf_token', false)) {
            $this->app->instance(VerifyCsrfToken::class, new KamrulMiddleware());
        }

        $this->app->booted(function () use ($config) {

            do_action(BASE_ACTION_INIT);
            add_action(BASE_ACTION_META_BOXES, [MetaBox::class, 'doMetaBoxes'], 8, 2);

            add_filter(BASE_FILTER_AFTER_SETTING_EMAIL_CONTENT, [EmailSettingHooks::class, 'addEmailTemplateSettings'], 99);

            $setting = $this->app->make(SettingStore::class);
            $timezone = $setting->get('time_zone', $config->get('app.timezone'));
            $locale = $setting->get('locale', $config->get('core.base.general.locale', $config->get('app.locale')));
//
            $config->set([
                'app.locale'   => $locale,
                'app.timezone' => $timezone,
            ]);

            $this->app->setLocale($locale);

            if (in_array($timezone, DateTimeZone::listIdentifiers())) {
                date_default_timezone_set($timezone);
            }


            foreach (array_keys($this->app->make(SlugHelper::class)->supportedModels()) as $item) {
                if (!class_exists($item)) {
                    continue;
                }

                /**
                 * @var DboardModel $item
                 */
                $item::resolveRelationUsing('slugable', function ($model) {
                    return $model->morphOne(Slug::class, 'reference')->select([
                        'key',
                        'reference_type',
                        'reference_id',
                        'prefix',
                    ]);
//                    return $model->morphOne(Slug::class, 'reference');
                });

                MacroableModels::addMacro($item, 'getSlugAttribute', function () {
//                    dd($this->slugable->key);
                    /**
                     * @var DboardModel $this
                     */
                    return $this->slugable ? $this->slugable->key : '';
                });

                MacroableModels::addMacro($item, 'getSlugIdAttribute', function () {
                    /**
                     * @var DboardModel $this
                     */
                    return $this->slugable ? $this->slugable->id : '';
                });

                MacroableModels::addMacro($item,
                    'getUrlAttribute',
                    function () {
                        /**
                         * @var DboardModel $this
                         */

                        if (!$this->slug) {
                            return url('');
                        }

                        if (get_class($this) == Page::class && DboardHelper::isHomepage($this->id)) {
                            return url('');
                        }

                        $prefix = $this->slugable ? $this->slugable->prefix : null;
                        $prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);

                        $prefix = \SlugHelper::getTranslator()->compile($prefix, $this);

                        return apply_filters('slug_filter_url', url($prefix ? $prefix . '/' . $this->slug : $this->slug));
                    });
            }
        });
    }

    protected function registerCssPublish()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/' . $this->moduleNameLower),
        ], $this->moduleNameLower . '_public');
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('DboardMedia', DboardMediaFacade::class);

        $this->app->bind(ResourceRegistrar::class, function ($app) {
            return new CustomResourceRegistrar($app['router']);
        });
        $this->app->register(RouteServiceProvider::class);
        $this->commandsRegister();
        $this->registerRepository();

        $this->app['config']->set([
            'session.cookie' => 'kamruldashboard_session',
            'ziggy.except' => ['debugbar.*'],
            'app.debug_blacklist' => [
                '_ENV' => [
                    'APP_KEY',
                    'ADMIN_DIR',
                    'DB_DATABASE',
                    'DB_USERNAME',
                    'DB_PASSWORD',
                    'REDIS_PASSWORD',
                    'MAIL_PASSWORD',
                    'PUSHER_APP_KEY',
                    'PUSHER_APP_SECRET',
                ],
                '_SERVER' => [
                    'APP_KEY',
                    'ADMIN_DIR',
                    'DB_DATABASE',
                    'DB_USERNAME',
                    'DB_PASSWORD',
                    'REDIS_PASSWORD',
                    'MAIL_PASSWORD',
                ],
                '_POST' => [
                    'password',
                ],
            ],
        ]);
//        dd($this->app['config']);

        $this->app->singleton('kamruldashboard:action', function () {
            return new Action();
        });

        $this->app->singleton('kamruldashboard:filter', function () {
            return new Filter();
        });
        $this->app->singleton(AdminWidgetContract::class, AdminWidget::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerRepository()
    {
        $this->app->bind(SlugInterface::class, function () {
            return new SlugRepository(new Slug);
        });
        $this->app->bind(MetaBoxInterface::class, function () {
            return new MetaBoxRepository(new MetaBoxModel);
        });
        $this->app->singleton(SettingsManager::class, function (Application $app) {
            return new SettingsManager($app);
        });
        AliasLoader::getInstance()->alias('Setting', SettingFacade::class);

        $this->app->singleton(SettingStore::class, function (Application $app) {
            return $app->make(SettingsManager::class)->driver();
        });
        $this->app->bind(SettingInterface::class, function () {
            return new SettingRepository(new SettingData);
        });
        $this->app->bind(SettingrowInterface::class, function () {
            return new SettingrowRepository(new Setting);
        });

        $this->app->bind(DashboardWidgetInterface::class, function () {
            return new DashboardWidgetRepository(new DashboardWidget);
        });

        $this->app->bind(DashboardWidgetSettingInterface::class, function () {
            return new DashboardWidgetSettingRepository(new DashboardWidgetSetting);
        });
        $this->app->bind(UserInterface::class, function () {
            return new UserRepository(new User);
        });
        $this->app->bind(PermissionInterface::class, function () {
            return new PermissionRepository(new Permission);
        });
        $this->app->bind(RoleInterface::class, function () {
            return new RoleRepository(new Role);
        });
    }
    private function commandsRegister()
    {
        $this->commands([
            \Modules\KamrulDashboard\Console\CreateInstallCommand::class,
            \Modules\KamrulDashboard\Console\CreateDataCommand::class,
            \Modules\KamrulDashboard\Console\CreateModelCommand::class,
            \Modules\KamrulDashboard\Console\BackupCreateCommand::class,
            \Modules\KamrulDashboard\Console\BackupListCommand::class,
            \Modules\KamrulDashboard\Console\BackupRemoveCommand::class,
            \Modules\KamrulDashboard\Console\BackupRestoreCommand::class,
            \Modules\KamrulDashboard\Console\CreateModelpublicCommand::class,
        ]);
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
        $config = $this->app->make('config');
        $config->set([
            'purifier.settings' => array_merge(
                $config->get('purifier.settings'),
                $config->get('kamruldashboard.purifier')
            ),
            'laravel-form-builder.defaults.wrapper_class' => 'form-group mb-3 col-md-12',
        ]);
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
//        $this->loadViewsFrom(__DIR__ . '/../Resources/views', $this->moduleNameLower);
//        dd($this->moduleNameLower);
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
        return [
            SettingsManager::class,
            SettingStore::class,
            SlugHelper::class,
        ];
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
