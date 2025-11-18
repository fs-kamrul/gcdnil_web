<?php

namespace Modules\AdminBoard\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\AdminBoard\Enums\AdminStudentGuidelineStatusEnum;
use Modules\AdminBoard\Http\Models\AdminAcademicGroup;
use Modules\AdminBoard\Http\Models\AdminCareerNavigator;
use Modules\AdminBoard\Http\Models\AdminCategory;
use Modules\AdminBoard\Http\Models\AdminClub;
use Modules\AdminBoard\Http\Models\AdminEvent;
use Modules\AdminBoard\Http\Models\AdminFacility;
use Modules\AdminBoard\Http\Models\AdminGallery;
use Modules\AdminBoard\Http\Models\AdminGalleryBoard;
use Modules\AdminBoard\Http\Models\AdminNews;
use Modules\AdminBoard\Http\Models\AdminNoticeBoard;
use Modules\AdminBoard\Http\Models\AdminStudentGuideline;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Modules\AdminBoard\Packages\Facades\AdminBoardFacade;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use SeoHelper;
use SlugHelper;
use EmailHandler;

class AdminBoardServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'AdminBoard';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'adminboard';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        SlugHelper::registerModule(AdminWorkshop::class, 'Workshop Posts');
        SlugHelper::setPrefix(AdminWorkshop::class, 'workshop', true);

        SlugHelper::registerModule(AdminNews::class, 'News Posts');
        SlugHelper::setPrefix(AdminNews::class, 'news', true);

        SlugHelper::registerModule(AdminEvent::class, 'Event Posts');
        SlugHelper::setPrefix(AdminEvent::class, 'event', true);

        SlugHelper::registerModule(AdminTeam::class, 'Faculty Posts');
        SlugHelper::setPrefix(AdminTeam::class, 'faculty', true);

        SlugHelper::registerModule(AdminCategory::class, 'Category Posts');
        SlugHelper::setPrefix(AdminCategory::class, 'category', true);

        SlugHelper::registerModule(AdminCareerNavigator::class, 'Syllabus Posts');
        SlugHelper::setPrefix(AdminCareerNavigator::class, 'syllabus', true);

        SlugHelper::registerModule(AdminFacility::class, 'Facilities Posts');
        SlugHelper::setPrefix(AdminFacility::class, 'facility', true);

        SlugHelper::registerModule(AdminNoticeBoard::class, 'Notice Boards Posts');
        SlugHelper::setPrefix(AdminNoticeBoard::class, 'notice-board', true);

        SlugHelper::registerModule(AdminAcademicGroup::class, 'Academic Group Data');
        SlugHelper::setPrefix(AdminAcademicGroup::class, 'academic-group', true);

        SlugHelper::registerModule(AdminGalleryBoard::class, 'Gallery Board Data');
        SlugHelper::setPrefix(AdminGalleryBoard::class, 'gallery-board', true);

        SlugHelper::registerModule(AdminClub::class, 'AdminClub Data');
        SlugHelper::setPrefix(AdminClub::class, 'clubs', true);

//        SlugHelper::registerModule(AdminStudentGuideline::class, 'Student guidelines Data');
//        SlugHelper::setPrefix(AdminStudentGuideline::class, 'student-guidelines', true);

        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadAndPublishConfigurations(['email'])
            ->publishAssets()
            ->loadHelpers();

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->booted(function () {
            SeoHelper::registerModule([
                AdminWorkshop::class,
                AdminNews::class,
                AdminEvent::class,
                AdminTeam::class,
                AdminNoticeBoard::class,
                AdminAcademicGroup::class,
                AdminGalleryBoard::class,
                AdminClub::class,
//                AdminCareerNavigator::class,
//                AdminFacility::class,
            ]);
            EmailHandler::addTemplateSettings(ADMIN_BOARD_MODULE_SCREEN_NAME, config('Modules.AdminBoard.email', []));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('AdminBoardHelper', AdminBoardFacade::class);
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
