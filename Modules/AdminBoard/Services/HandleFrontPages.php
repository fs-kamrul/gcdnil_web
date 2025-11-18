<?php

namespace Modules\AdminBoard\Services;


use Modules\AdminBoard\Http\Models\AdminCareerNavigator;
use Modules\AdminBoard\Http\Models\AdminClub;
use Modules\AdminBoard\Http\Models\AdminEvent;
use Modules\AdminBoard\Http\Models\AdminFacility;
use Modules\AdminBoard\Http\Models\AdminGalleryBoard;
use Modules\AdminBoard\Http\Models\AdminNews;
use Modules\AdminBoard\Http\Models\AdminNoticeBoard;
use Modules\AdminBoard\Http\Models\AdminAcademicGroup;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Modules\AdminBoard\Repositories\Interfaces\AdminCareerNavigatorInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminClubInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminEventInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminFacilityInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminGalleryBoardInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminNewsInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminNoticeBoardInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminAcademicGroupInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminTeamInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminWorkshopInterface;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Packages\Supports\Helper;
use Modules\SeoHelper\Packages\Supports\SeoOpenGraph;
use SeoHelper;
use AdminBoardHelper;
use MetaBox;
use Theme;
use Illuminate\Support\Str;

class HandleFrontPages
{
    public function handle( $slug)
    {
        if (! $slug instanceof Slug) {
            return $slug;
        }

        $request = request();

//        return $slug;
        switch ($slug->reference_type) {
            case AdminWorkshop::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminWorkshopInterface::class);
                $workshop = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminWorkshopRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $workshop) {
                    abort(404);
                }

                if ($workshop->slugable->key !== $slug->key) {
                    return redirect()->to($workshop->url);
                }

                SeoHelper::setTitle($workshop->name)->setDescription(Str::words($workshop->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($workshop->image) {
                    $meta->setImage(url(getImageUrl($workshop->photo, 'adminboard/adminworkshop')));
                }
                $meta->setDescription($workshop->short_description);
                $meta->setUrl($workshop->url);
                $meta->setTitle($workshop->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($workshop, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

//                Theme::breadcrumb()
//                    ->add(__('Admin Workshop'), route('public.adminworkshop'))
//                    ->add($workshop->name);

                Helper::handleViewCount($workshop, 'viewed_workshop');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINNEWS_MODULE_SCREEN_NAME, $workshop);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this workshop'), route('adminworkshop.edit', $workshop->id));
                }

                $images = [];
                $images_array = $workshop->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

                $workshops = AdminBoardHelper::getWorkshopFilter((int) theme_option('number_of_workshops_per_page') ?: 12, []);
                $up_workshops = AdminBoardHelper::getWorkshopFilter(4, []);
                return [
                    'view' => 'admin_board.workshop',
                    'default_view' => 'adminboard::themes.workshop',
                    'data' => compact('workshop', 'workshops', 'up_workshops', 'images'),
                    'slug' => $workshop->slug,
                ];

            case AdminNews::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminNewsInterface::class);
                $News = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminNewsRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $News) {
                    abort(404);
                }

                if ($News->slugable->key !== $slug->key) {
                    return redirect()->to($News->url);
                }

                SeoHelper::setTitle($News->name)->setDescription(Str::words($News->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($News->image) {
                    $meta->setImage(url(getImageUrl($News->photo, 'adminboard/adminnews')));
                }
                $meta->setDescription($News->short_description);
                $meta->setUrl($News->url);
                $meta->setTitle($News->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($News, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.adminnews'), route('public.adminnews'))
                    ->add($News->name);

                Helper::handleViewCount($News, 'viewed_news');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINBOARD_MODULE_SCREEN_NAME, $News);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this News'), route('adminnews.edit', $News->id));
                }

                $images = [];
                $images_array = $News->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

                //(int) theme_option('number_of_news_per_page') ?: 12
                $Newses_post = AdminBoardHelper::getNewsFilter(7, []);
                $Newses = $Newses_post->reject(function ($item) use ($News) {
                    return $item->id == $News->id;
                });
                return [
                    'view' => 'admin_board.news',
                    'default_view' => 'adminboard::themes.news',
                    'data' => compact('News', 'Newses', 'images'),
                    'slug' => $News->slug,
                ];

            case AdminEvent::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminEventInterface::class);
                $event = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminEventRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $event) {
                    abort(404);
                }

                if ($event->slugable->key !== $slug->key) {
                    return redirect()->to($event->url);
                }

                SeoHelper::setTitle($event->name)->setDescription(Str::words($event->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($event->image) {
                    $meta->setImage(url(getImageUrl($event->photo, 'adminboard/adminevent')));
                }
                $meta->setDescription($event->short_description);
                $meta->setUrl($event->url);
                $meta->setTitle($event->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($event, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.adminevent'), route('public.adminevent'))
                    ->add($event->name);

                Helper::handleViewCount($event, 'viewed_event');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINBOARD_MODULE_SCREEN_NAME, $event);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this Event'), route('adminevent.edit', $event->id));
                }

                $images = [];
                $images_array = $event->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

                //(int) theme_option('number_of_event_per_page') ?: 12
                $events_post = AdminBoardHelper::getEventFilter(7, []);
                $events = $events_post->reject(function ($item) use ($event) {
                    return $item->id == $event->id;
                });
//                $up_events = AdminBoardHelper::getEventFilter(4, []);
                return [
                    'view' => 'admin_board.event',
                    'default_view' => 'adminboard::themes.event',
                    'data' => compact('event', 'events', 'images'),
                    'slug' => $event->slug,
                ];
            case AdminTeam::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminTeamInterface::class);
                $team = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminTeamRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $team) {
                    abort(404);
                }

                if ($team->slugable->key !== $slug->key) {
                    return redirect()->to($team->url);
                }

                SeoHelper::setTitle($team->name)->setDescription(Str::words($team->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($team->image) {
                    $meta->setImage(url(getImageUrl($team->photo, 'adminboard/adminteam')));
                }
                $meta->setDescription($team->short_description);
                $meta->setUrl($team->url);
                $meta->setTitle($team->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($team, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('Faculty'), route('public.adminteam'))
                    ->add($team->name);

                Helper::handleViewCount($team, 'viewed_team');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINBOARD_MODULE_SCREEN_NAME, $team);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this Team'), route('adminteam.edit', $team->id));
                }

                $images = [];
                $images_array = $team->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

                $teams = AdminBoardHelper::getTeamFilter((int) theme_option('number_of_team_per_page') ?: 12, []);
//                $up_teams = AdminBoardHelper::getEventFilter(4, []);
                return [
                    'view' => 'admin_board.team',
                    'default_view' => 'adminboard::themes.team',
                    'data' => compact('team', 'teams', 'images'),
                    'slug' => $team->slug,
                ];
            case AdminCareerNavigator::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminCareerNavigatorInterface::class);
                $career_navigator = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminCareerNavigatorRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $career_navigator) {
                    abort(404);
                }

                if ($career_navigator->slugable->key !== $slug->key) {
                    return redirect()->to($career_navigator->url);
                }

                SeoHelper::setTitle($career_navigator->name)->setDescription(Str::words($career_navigator->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($career_navigator->image) {
                    $meta->setImage(url(getImageUrl($career_navigator->photo, 'adminboard/admincareernavigator')));
                }
                $meta->setDescription($career_navigator->short_description);
                $meta->setUrl($career_navigator->url);
                $meta->setTitle($career_navigator->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($career_navigator, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.admincareernavigator'), route('public.admincareernavigator'))
                    ->add($career_navigator->name);
//                Theme::breadcrumb()
//                    ->add(__('Admin Career Navigator'), route('public.admincareernavigator'))
//                    ->add($career_navigator->name);

                Helper::handleViewCount($career_navigator, 'viewed_career_navigator');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINBOARD_MODULE_SCREEN_NAME, $career_navigator);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this Career Navigator'), route('admincareernavigator.edit', $career_navigator->id));
                }

                $images = [];
                $images_array = $career_navigator->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

                $career_navigators = AdminBoardHelper::getCareerNavigatorFilter((int) theme_option('number_of_career_navigators_per_page') ?: 12, []);
                $up_career_navigators = AdminBoardHelper::getEventFilter(4, []);
                return [
                    'view' => 'admin_board.career_navigator',
                    'default_view' => 'adminboard::themes.career_navigator',
                    'data' => compact('career_navigator', 'career_navigators','up_career_navigators', 'images'),
                    'slug' => $career_navigator->slug,
                ];
            case AdminNoticeBoard::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminNoticeBoardInterface::class);
                $notice_board = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminNoticeBoardRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $notice_board) {
                    abort(404);
                }

                if ($notice_board->slugable->key !== $slug->key) {
                    return redirect()->to($notice_board->url);
                }

                SeoHelper::setTitle($notice_board->name)->setDescription(Str::words($notice_board->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($notice_board->image) {
                    $meta->setImage(url(getImageUrl($notice_board->photo, 'adminboard/adminnoticeboard')));
                }
                $meta->setDescription($notice_board->short_description);
                $meta->setUrl($notice_board->url);
                $meta->setTitle($notice_board->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($notice_board, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.adminnoticeboard'), route('public.adminnoticeboard'))
                    ->add($notice_board->name);
//                Theme::breadcrumb()
//                    ->add(__('Admin notice_board'), route('public.adminnotice_board'))
//                    ->add($notice_board->name);

                Helper::handleViewCount($notice_board, 'viewed_notice_board');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINNEWS_MODULE_SCREEN_NAME, $notice_board);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this notice_board'), route('adminnoticeboard.edit', $notice_board->id));
                }

                $images = [];
                $images_array = $notice_board->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

                $notice_boards = AdminBoardHelper::getNoticeBoardFilter((int) theme_option('number_of_notice_boards_per_page') ?: 12, []);
//                $up_notice_boards = AdminBoardHelper::getNoticeBoardFilter(4, []);
                return [
                    'view' => 'admin_board.notice_board',
                    'default_view' => 'adminboard::themes.notice_board',
                    'data' => compact('notice_board', 'notice_boards', 'images'),
                    'slug' => $notice_board->slug,
                ];

            case AdminAcademicGroup::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminAcademicGroupInterface::class);
                $academic_group = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminAcademicGroupRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $academic_group) {
                    abort(404);
                }

                if ($academic_group->slugable->key !== $slug->key) {
                    return redirect()->to($academic_group->url);
                }

                SeoHelper::setTitle($academic_group->name)->setDescription(Str::words($academic_group->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($academic_group->image) {
                    $meta->setImage(url(getImageUrl($academic_group->photo, 'adminboard/adminacademicgroup')));
                }
                $meta->setDescription($academic_group->short_description);
                $meta->setUrl($academic_group->url);
                $meta->setTitle($academic_group->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($academic_group, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.adminacademicgroup'), route('public.adminacademicgroup'))
                    ->add($academic_group->name);
//                Theme::breadcrumb()
//                    ->add(__('Admin academic_group'), route('public.adminacademic_group'))
//                    ->add($academic_group->name);

                Helper::handleViewCount($academic_group, 'viewed_academic_group');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINNEWS_MODULE_SCREEN_NAME, $academic_group);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this academic_group'), route('adminacademicgroup.edit', $academic_group->id));
                }

                $images = [];
                $images_array = $academic_group->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

//                $academic_groups = AdminBoardHelper::getAcademicGroupFilter((int) theme_option('number_of_academic_groups_per_page') ?: 12, []);
//                $up_academic_groups = AdminBoardHelper::getAcademicGroupFilter(4, []);
                return [
                    'view' => 'admin_board.academic_group',
                    'default_view' => 'adminboard::themes.academic_group',
                    'data' => compact('academic_group', 'images'),
                    'slug' => $academic_group->slug,
                ];
            case AdminGalleryBoard::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminGalleryBoardInterface::class);
                $admin_gallery_board = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminGalleryBoardRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $admin_gallery_board) {
                    abort(404);
                }

                if ($admin_gallery_board->slugable->key !== $slug->key) {
                    return redirect()->to($admin_gallery_board->url);
                }

                SeoHelper::setTitle($admin_gallery_board->name)->setDescription(Str::words($admin_gallery_board->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($admin_gallery_board->image) {
                    $meta->setImage(url(getImageUrl($admin_gallery_board->photo, 'adminboard/admingalleryboard')));
                }
                $meta->setDescription($admin_gallery_board->short_description);
                $meta->setUrl($admin_gallery_board->url);
                $meta->setTitle($admin_gallery_board->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($admin_gallery_board, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.admingalleryboard'), route('public.admingalleryboard'))
                    ->add($admin_gallery_board->name);

                Theme::asset()
                    ->usePath(false)
                    ->add('gallery', url('vendor/Modules/AdminBoard/css/gallery.css'),
                        [], [], '1.0.0',true);
                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('notice_boards', url('vendor/Modules/AdminBoard/js/gallery_public.js'),
                        ['jquery'], [], '1.0.0');
//                Theme::breadcrumb()
//                    ->add(__('Admin admin_gallery_board'), route('public.adminnoticeboard'))
//                    ->add($admin_gallery_board->name);

                Helper::handleViewCount($admin_gallery_board, 'viewed_admin_gallery_board');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINNEWS_MODULE_SCREEN_NAME, $admin_gallery_board);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this gallery board'), route('admingalleryboard.edit', $admin_gallery_board->id));
                }

                $images = [];
                $images_array = $admin_gallery_board->AdminGalleryParameter;
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }
                return [
                    'view' => 'admin_board.admin_gallery_board',
                    'default_view' => 'adminboard::themes.admin_gallery_board',
                    'data' => compact('admin_gallery_board', 'images'),
                    'slug' => $admin_gallery_board->slug,
                ];
            case AdminFacility::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminFacilityInterface::class);
                $facility = $adminBoardRepository->advancedGet(array_merge([
//                    'with' => AdminBoardHelper::getAdminFacilityRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $facility) {
                    abort(404);
                }

                if ($facility->slugable->key !== $slug->key) {
                    return redirect()->to($facility->url);
                }

                SeoHelper::setTitle($facility->name)->setDescription(Str::words($facility->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($facility->image) {
                    $meta->setImage(url(getImageUrl($facility->photo, 'adminboard/adminfacility')));
                }
                $meta->setDescription($facility->short_description);
                $meta->setUrl($facility->url);
                $meta->setTitle($facility->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($facility, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
//                    ->add(__('Facility'), route('public.adminfacility'))
//                    ->add(__('Facility'), '#')
                    ->add($facility->name);

                Helper::handleViewCount($facility, 'viewed_facility');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINBOARD_MODULE_SCREEN_NAME, $facility);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this Facility'), route('adminfacility.edit', $facility->id));
                }

                $images = [];
                $images_array = $facility->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

//                $facilitys = AdminBoardHelper::getFacilityFilter((int) theme_option('number_of_facility_per_page') ?: 12, []);
//                $up_facilitys = AdminBoardHelper::getEventFilter(4, []);
                return [
                    'view' => 'admin_board.facility',
                    'default_view' => 'adminboard::themes.facility',
                    'data' => compact('facility', 'images'),
                    'slug' => $facility->slug,
                ];
            case AdminClub::class:
                $path = 'adminboard/shortcode';
                $adminBoardRepository = app(AdminClubInterface::class);
                $admin_club = $adminBoardRepository->advancedGet(array_merge([
                    'with' => AdminBoardHelper::getAdminClubRelationsQuery(),
                    'condition' => ['id' => $slug->reference_id],
                    'take' => 1,
                ]));
//                ], AdminBoardHelper::getReviewExtraData()));

                if (! $admin_club) {
                    abort(404);
                }

                if ($admin_club->slugable->key !== $slug->key) {
                    return redirect()->to($admin_club->url);
                }

                SeoHelper::setTitle($admin_club->name)->setDescription(Str::words($admin_club->short_description, 120));

                $meta = new SeoOpenGraph();
                if ($admin_club->image) {
                    $meta->setImage(url(getImageUrl($admin_club->photo, 'adminboard/adminclub')));
                }
                $meta->setDescription($admin_club->short_description);
                $meta->setUrl($admin_club->url);
                $meta->setTitle($admin_club->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                Theme::uses(Theme::getThemeName())->layout(setting('layout', 'other_page'));
                $layout = MetaBox::getMetaData($admin_club, 'layout', true);
                $layout = ($layout && in_array($layout, array_keys(get_admin_board_layouts()))) ? $layout : 'admin-default';
//                Theme::layout($layout);
                Theme::uses(Theme::getThemeName())->layout($layout);

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'))
                    ->add(__('adminboard::lang.adminclub'), route('public.adminclub'))
                    ->add($admin_club->name);
//                Theme::breadcrumb()
//                    ->add(__('Admin admin_club'), route('public.adminadmin_club'))
//                    ->add($admin_club->name);

                Helper::handleViewCount($admin_club, 'viewed_admin_club');

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ADMINCLUB_MODULE_SCREEN_NAME, $admin_club);

                if (function_exists('admin_bar')) {
                    admin_bar()->registerLink(__('Edit this admin_club'), route('adminclub.edit', $admin_club->id));
                }

                $images = [];
                $images_array = $admin_club->AdminGalleryParameter->toArray();
                if (! empty($images_array)) {
                    foreach ($images_array as $imagep) {
//                        dd($image['id']);
                        $images[] = getAdminImageUrlById($imagep['id'], $path);
                    }
                }

//                $admin_clubs = AdminBoardHelper::getAcademicGroupFilter((int) theme_option('number_of_admin_clubs_per_page') ?: 12, []);
//                $up_admin_clubs = AdminBoardHelper::getAcademicGroupFilter(4, []);
                return [
                    'view' => 'admin_board.admin_club',
                    'default_view' => 'adminboard::themes.admin_club',
                    'data' => compact('admin_club', 'images'),
                    'slug' => $admin_club->slug,
                ];

        }

        return $slug;
    }
}
