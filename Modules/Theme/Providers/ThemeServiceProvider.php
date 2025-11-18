<?php

namespace Modules\Theme\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Theme\Contracts\Theme  as ThemeContract;
use Config;
use Modules\KamrulDashboard\Packages\Supports\DashboardWidgetInstance;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Theme;
use Form;
use Throwable;

class ThemeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Theme';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'theme';
    protected $viewPath = 'theme';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadHelpers();

        $this->app->bind(ThemeContract::class, Theme::class);

        $this->registerTranslations();
        $this->registerCssPublish();
        $this->registerConfig();
        $this->registerViews();
//        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->add_shortcode();
        $this->app->register(FormServiceProvider::class);
        $this->app->register(ThemeManagementServiceProvider::class);

        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addStatsWidgets'], 4, 2);
//        Paginator::defaultView(theme_path(Theme::getThemeName() . '/partials/pagination'));
//        Paginator::defaultView(Theme::partial('pagination'));
//        Paginator::defaultSimpleView(Theme::partial('simple-pagination'));
        Paginator::defaultView('theme::partials.pagination');
        Paginator::defaultSimpleView('theme::partials.simple-pagination');
    }
    protected function registerCssPublish()
    {
        $this->publishes([
            theme_path(Theme::getThemeName() . '/public') => public_path(config('theme.themeDir') . '/' . Theme::getThemeName()),
        ], strtolower(Theme::getThemeName()) . '_public');
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addStatsWidgets($widgets, $widgetSettings)
    {
        $themes = count(scan_folder(theme_path()));

        return (new DashboardWidgetInstance)
            ->setType('stats')
            ->setPermission('theme_index')
            ->setTitle(trans('theme::lang.theme'))
            ->setKey('widget_total_themes')
            ->setIcon('fa fa-paint-brush')
            ->setColor('#e7505a')
            ->setStatsTotal($themes)
            ->setRoute(route('theme.index'))
            ->init($widgets, $widgetSettings);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function add_shortcode()
    {
        $viewPath = 'theme';
//        add_shortcode('youtube-video', __('theme::lang.youtube_video'), __('theme::lang.add_youtube_video'),
//            function ($shortcode) use ($viewPath) {
//                $url = Youtube::getYoutubeVideoEmbedURL($shortcode->content);
////                return view(($viewPath ?: 'theme::shortcodes') . '.youtube', compact('url'))->render();
//                return view('theme::shortcodes.youtube', compact('url'))->render();
//            });
//
//        shortcode()->setAdminConfig('youtube-video', function ($attributes, $content) use ($viewPath) {
////            return view(($viewPath ?: 'theme::shortcodes') . '.youtube-admin-config', compact('attributes', 'content'))->render();
//            return view('theme::shortcodes.youtube-admin-config', compact('attributes', 'content'))->render();
//        });

//        add_shortcode('kamrul_kkr','kamrul kkr', 'Add  Kamrul',[$this, 'form']);
//        shortcode()->setAdminConfig('kamrul_kkr', '[kamrul_i][/kamrul_i]' );

        theme_option()
            ->setArgs(['debug' => config('app.debug')])
            ->setSection([
                'title'      => trans('theme::theme.theme_option_general'),
                'desc'       => trans('theme::theme.theme_option_general_description'),
                'priority'   => 0,
                'id'         => 'opt-text-subsection-general',
                'subsection' => true,
                'icon'       => 'fa fa-home',
                'fields'     => [
                    [
                        'id'         => 'site_title',
                        'type'       => 'text',
                        'label'      => trans('theme::theme.site_title'),
                        'attributes' => [
                            'name'    => 'site_title',
                            'value'   => null,
                            'options' => [
                                'class'        => 'form-control',
                                'placeholder'  => trans('theme::theme.site_title'),
                                'data-counter' => 255,
                            ],
                        ],
                    ],
                    [
                        'id'         => 'show_site_name',
                        'section_id' => 'opt-text-subsection-general',
                        'type'       => 'select',
                        'label'      => trans('theme::theme.show_site_name'),
                        'attributes' => [
                            'name'    => 'show_site_name',
                            'list'    => [
                                '0' => 'No',
                                '1' => 'Yes',
                            ],
                            'value'   => '0',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'id'         => 'seo_title',
                        'type'       => 'text',
                        'label'      => trans('theme::theme.seo_title'),
                        'attributes' => [
                            'name'    => 'seo_title',
                            'value'   => null,
                            'options' => [
                                'class'        => 'form-control',
                                'placeholder'  => trans('theme::theme.seo_title'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],
                    [
                        'id'         => 'seo_description',
                        'type'       => 'textarea',
                        'label'      => trans('theme::theme.seo_description'),
                        'attributes' => [
                            'name'    => 'seo_description',
                            'value'   => null,
                            'options' => [
                                'class' => 'form-control',
                                'rows'  => 4,
                            ],
                        ],
                    ],
                    [
                        'id'         => 'seo_og_image',
                        'type'       => 'seoImage',
                        'label'      => trans('theme::theme.theme_option_seo_open_graph_image'),
                        'attributes' => [
                            'name'  => 'seo_og_image',
                            'value' => null,
                            [
                                'class' => 'form-control',
                            ]
                        ],
                    ],
                ],
            ])
            ->setSection([
                'title'      => trans('theme::theme.theme_option_logo'),
                'desc'       => trans('theme::theme.theme_option_logo'),
                'priority'   => 0,
                'id'         => 'opt-text-subsection-logo',
                'subsection' => true,
                'icon'       => 'fa fa-image',
                'fields'     => [
                    [
                        'id'         => 'favicon',
                        'type'       => 'faviconImage',
                        'label'      => trans('theme::theme.theme_option_favicon'),
                        'attributes' => [
                            'name'  => 'favicon',
                            'value' => null,
                        ],
                    ],
                    [
                        'id'         => 'logo',
                        'type'       => 'logoImage',
                        'label'      => trans('theme::theme.theme_option_logo'),
                        'attributes' => [
                            'name'  => 'logo',
                            'value' => null,
                        ],
                    ],
                    [
                        'id'         => 'logo_color',
                        'type'       => 'logoImage',
                        'label'      => trans('theme::theme.theme_option_footer_logo'),
                        'attributes' => [
                            'name'  => 'logo_color',
                            'value' => null,
                        ],
                    ],
                ],
            ]);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->commandsRegister();
    }

    private function commandsRegister()
    {
        $this->commands([
            \Modules\Theme\Console\ThemeRenameCommand::class,
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

        $langPath_themes = resource_path('lang/' . strtolower(Theme::getThemeName()));

        if (is_dir($langPath_themes)) {
            $this->loadTranslationsFrom($langPath_themes, strtolower(Theme::getThemeName()));
        } else {
            $this->loadTranslationsFrom(theme_path(Theme::getThemeName() . '/Resources/lang'), strtolower(Theme::getThemeName()));
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
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
