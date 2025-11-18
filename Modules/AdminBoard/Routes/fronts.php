<?php
use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Modules\AdminBoard\Http\Models\AdminEvent;
use Modules\AdminBoard\Http\Models\AdminGalleryBoard;
use Modules\AdminBoard\Http\Models\AdminGallery;
use Modules\AdminBoard\Http\Models\AdminFacility;
use Modules\AdminBoard\Http\Models\AdminNews;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\AdminBoard\Http\Controllers\PublicController;
use Modules\AdminBoard\Http\Models\AdminCareerNavigator;
use Modules\AdminBoard\Http\Models\AdminNoticeBoard;
use Modules\AdminBoard\Http\Models\AdminAcademicGroup;
use Modules\AdminBoard\Http\Models\AdminClub;
USE Modules\AdminBoard\Http\Models\AdminStudentGuideline;

Route::group(['namespace' => 'Modules\AdminBoard\Http\Controllers', 'middleware' => ['web']], function () {

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE, []), function () {

            $workshopPrefix = SlugHelper::getPrefix(AdminWorkshop::class, 'workshop') ?: 'workshop';
            $newsPrefix = SlugHelper::getPrefix(AdminNews::class, 'news') ?: 'news';
            $eventPrefix = SlugHelper::getPrefix(AdminEvent::class, 'event') ?: 'event';
            $teamPrefix = SlugHelper::getPrefix(AdminTeam::class, 'faculty') ?: 'faculty';
            $career_navigatorsPrefix = SlugHelper::getPrefix(AdminCareerNavigator::class, 'academic-resources') ?: 'academic-resources';
            $notice_boardPrefix = SlugHelper::getPrefix(AdminNoticeBoard::class, 'notice-board') ?: 'notice-board';
            $adminAcademicGroupPrefix = SlugHelper::getPrefix(AdminAcademicGroup::class, 'academic-group') ?: 'academic-group';
            $admin_student_guidelinesPrefix = SlugHelper::getPrefix(AdminStudentGuideline::class, 'student-guidelines') ?: 'student-guidelines';
            $galleryPrefix = SlugHelper::getPrefix(AdminGalleryBoard::class, 'gallery') ?: 'gallery';
            $facilityPrefix = SlugHelper::getPrefix(AdminFacility::class, 'facility') ?: 'facility';
            $adminClubPrefix = SlugHelper::getPrefix(AdminClub::class, 'clubs') ?: 'clubs';

            Route::match(theme_option('workshop_list_page_id') ? ['POST'] : ['POST', 'GET'], $workshopPrefix, [PublicController::class, 'getWorkshop'])
                ->name('public.adminworkshop');
            Route::match(theme_option('news_list_page_id') ? ['POST'] : ['POST', 'GET'], $newsPrefix, [PublicController::class, 'getNews'])
                ->name('public.adminnews');
            Route::match(theme_option('event_list_page_id') ? ['POST'] : ['POST', 'GET'], $eventPrefix, [PublicController::class, 'getEvent'])
                ->name('public.adminevent');
            Route::match(theme_option('team_list_page_id') ? ['POST'] : ['POST', 'GET'], $teamPrefix, [PublicController::class, 'getTeam'])
                ->name('public.adminteam');
            Route::match(theme_option('career_navigators_list_page_id') ? ['POST'] : ['POST', 'GET'], $career_navigatorsPrefix, [PublicController::class, 'getCareerNavigators'])
                ->name('public.admincareernavigator');
            Route::match(theme_option('notice_board_list_page_id') ? ['POST'] : ['POST', 'GET'], $notice_boardPrefix, [PublicController::class, 'getNoticeBoard'])
                ->name('public.adminnoticeboard');
            Route::post('/noticeboard/filter', [PublicController::class, 'filterNoticeBoard'])->name('noticeboard.filter');


            Route::match(theme_option('academic_group_list_page_id') ? ['POST'] : ['POST', 'GET'], $adminAcademicGroupPrefix, [PublicController::class, 'getAcademicGroupPrefix'])
                ->name('public.adminacademicgroup');
            Route::match(theme_option('student_guidelines_page_id') ? ['POST'] : ['POST', 'GET'], $admin_student_guidelinesPrefix, [PublicController::class, 'getStudentGuidelines'])
                ->name('public.adminstudentguideline');
            Route::match(theme_option('gallery_list_page_id') ? ['POST'] : ['POST', 'GET'], $galleryPrefix, [PublicController::class, 'getGalleryBoard'])
                ->name('public.admingalleryboard');
            Route::match(theme_option('facility_list_page_id') ? ['POST'] : ['POST', 'GET'], $facilityPrefix, [PublicController::class, 'getFacility'])
                ->name('public.adminfacility');
            Route::match(theme_option('academic_group_list_page_id') ? ['POST'] : ['POST', 'GET'], $adminClubPrefix, [PublicController::class, 'getAdminClubPrefix'])
                ->name('public.adminclub');
        });
    }
});
