<?php

namespace Modules\Analytics\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\KamrulDashboard\Packages\Supports\DashboardWidgetInstance;
use Throwable;
use Assets;
use Language;

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
//add_new_line_Interface_and_Repository_to_hook


        if (config('analytics.enabled_dashboard_widgets')) {
            add_action(DASHBOARD_ACTION_REGISTER_SCRIPTS, [$this, 'registerScripts'], 18);
            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addAnalyticsWidgets'], 18, 2);
//            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addGeneralWidget'], 18, 2);
//            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addPageWidget'], 19, 2);
//            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addBrowserWidget'], 20, 2);
//            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addReferrerWidget'], 22, 2);
            add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addAnalyticsSetting'], 99);
            add_filter('cms_settings_validation_rules', [$this, 'addAnalyticsSettingRules'], 99);
            add_filter('core_layout_before_content', [$this, 'showMissingLibraryWarning'], 99);
        }


        if (! $this->app->runningInConsole() && is_module_active('Language')) {
//        if (!is_in_admin()) {
            add_filter(FILTER_GROUP_PUBLIC_ROUTE, [$this, 'addLanguageMiddlewareToPublicRoute'], 958);
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function addLanguageMiddlewareToPublicRoute(array $data): array
    {
        $locale = Language::setLocale();

        if (! isset($data['prefix'])) {
            $data['prefix'] = trim((string)$locale);
        }

        $data['middleware'] = array_merge(Arr::get($data, 'middleware', []), [
            'localeSessionRedirect',
            'localizationRedirect',
        ]);

        $data['middleware'] = array_unique($data['middleware']);

//        dd($data);
        return $data;
    }
    /**
     * @return void
     */
    public function registerScripts()
    {
        if(auth()->user()->can('analytics_access')) {
            Assets::addScripts(['raphael', 'morris'])
                ->addStyles(['morris'])
                ->addStylesDirectly([
                    'vendor/Modules/Analytics/libraries/jvectormap/jquery-jvectormap-1.2.2.css',
                ])
                ->addScriptsDirectly([
                    'vendor/Modules/Analytics/libraries/jvectormap/jquery-jvectormap-1.2.2.min.js',
                    'vendor/Modules/Analytics/libraries/jvectormap/jquery-jvectormap-world-mill-en.js',
                    'vendor/Modules/Analytics/js/analytics.js',
                ]);
        }
    }


    public function addAnalyticsWidgets(array $widgets, Collection $widgetSettings): array
    {
        $dashboardWidgetInstance = new DashboardWidgetInstance();

        $widgets = $dashboardWidgetInstance
            ->setPermission('analytics_general')
            ->setKey('widget_analytics_general')
            ->setTitle(trans('analytics::analytics.widget_analytics_general'))
            ->setIcon('icon-chart-line')
            ->setColor('#f2784b')
            ->setRoute(route('analytics.general'))
            ->setBodyClass('row')
            ->setColumn('col-md-12 col-sm-12 col-lg-12')
            ->setHasLoadCallback(true)
            ->setIsEqualHeight(false)
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);

        $widgets = $dashboardWidgetInstance
            ->setPermission('analytics_page')
            ->setKey('widget_analytics_page')
            ->setTitle(trans('analytics::analytics.widget_analytics_page'))
            ->setIcon('icon-newspaper2')
            ->setColor('#3598dc')
            ->setRoute(route('analytics.page'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);

        $widgets = $dashboardWidgetInstance
            ->setPermission('analytics_browser')
            ->setKey('widget_analytics_browser')
            ->setTitle(trans('analytics::analytics.widget_analytics_browser'))
            ->setIcon('icon-safari')
            ->setColor('#8e44ad')
            ->setRoute(route('analytics.browser'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);

        return $dashboardWidgetInstance
            ->setPermission('analytics_referrer')
            ->setKey('widget_analytics_referrer')
            ->setTitle(trans('analytics::analytics.widget_analytics_referrer'))
            ->setIcon('icon-user-friends')
            ->setColor('#3598dc')
            ->setRoute(route('analytics.referrer'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-sm-6')
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);
    }
    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addGeneralWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics_access')
            ->setKey('widget_analytics_general')
            ->setTitle(trans('analytics::lang.widget_analytics_general'))
            ->setIcon('fa fa-line-chart')
            ->setColor('#f2784b')
            ->setRoute(route('analytics.general'))
            ->setBodyClass('row')
            ->setColumn('col-md-12 col-sm-12 col-lg-12')
            ->setHasLoadCallback(true)
            ->setIsEqualHeight(false)
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);
    }
    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addPageWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics_page')
            ->setKey('widget_analytics_page')
            ->setTitle(trans('analytics::lang.widget_analytics_page'))
            ->setIcon('far fa-newspaper')
            ->setColor('#3598dc')
            ->setRoute(route('analytics.page'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-lg-6 col-sm-12')
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);
    }
    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addBrowserWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics_browser')
            ->setKey('widget_analytics_browser')
            ->setTitle(trans('analytics::lang.widget_analytics_browser'))
            ->setIcon('fab fa-safari')
            ->setColor('#8e44ad')
            ->setRoute(route('analytics.browser'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-lg-6 col-sm-12')
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);
    }
    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addReferrerWidget($widgets, $widgetSettings)
    {
        return (new DashboardWidgetInstance)
            ->setPermission('analytics_referrer')
            ->setKey('widget_analytics_referrer')
            ->setTitle(trans('analytics::lang.widget_analytics_referrer'))
            ->setIcon('fas fa-user-friends')
            ->setColor('#3598dc')
            ->setRoute(route('analytics.referrer'))
            ->setBodyClass('scroll-table')
            ->setColumn('col-md-6 col-lg-6 col-sm-12')
            ->setSettings(['show_predefined_ranges' => true])
            ->init($widgets, $widgetSettings);
    }
    /**
     * @param null|string $data
     * @return string
     * @throws Throwable
     */
    public function addAnalyticsSetting($data = null): string
    {
        return $data . view('analytics::setting')->render();
    }
    public function addAnalyticsSettingRules(array $rules): array
    {
        $rules['google_analytics'] = 'nullable|string|starts_with:G-';
        $rules['analytics_property_id'] = 'nullable|string|min:9|max:9';
        $rules['analytics_service_account_credentials'] = 'nullable|json';

        return $rules;
    }
    public function showMissingLibraryWarning($html)
    {
        if (! Route::is('plugins.index') || class_exists('Google\Service\Analytics\GaData')) {
            return $html;
        }

        return $html . view('analytics::missing-library-warning')->render();
    }
}
