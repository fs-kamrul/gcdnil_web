<?php

//use Modules\Theme\Events\ThemeRoutingBeforeEvent;
//use Modules\Theme\Events\ThemeRoutingAfterEvent;
use Modules\AdminBoard\Http\Models\AdminWorkshop;


Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('adminboard')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'AdminBoardController@import')->name('adminboard.import');
    //    Route::post('/store_import', 'AdminBoardController@store_import')->name('adminboard.store_import');
    //    Route::get('/pdf_show/{adminboard}', 'AdminBoardController@pdf')->name('adminboard.pdf_show');

    });
  //  Route::get('api/adminboard','AdminBoardController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix(). '/adminboard'], function () {
        Route::resource('adminclub', 'AdminClubController');
        Route::delete('adminclub/items/destroy', [
            'as'         => 'adminclub.deletes',
            'uses'       => 'AdminClubController@deletes',
        ]);

        Route::resource('adminboard', 'AdminBoardController');
        Route::delete('adminboard/items/destroy', [
            'as'         => 'adminboard.deletes',
            'uses'       => 'AdminBoardController@deletes',
        ]);

        Route::resource('adminworkshop', 'AdminWorkshopController');
        Route::delete('adminworkshop/items/destroy', [
            'as'         => 'adminworkshop.deletes',
            'uses'       => 'AdminWorkshopController@deletes',
        ]);

        Route::resource('adminnews', 'AdminNewsController');
        Route::delete('adminnews/items/destroy', [
            'as'         => 'adminnews.deletes',
            'uses'       => 'AdminNewsController@deletes',
        ]);

        Route::resource('adminevent', 'AdminEventController');
        Route::delete('adminevent/items/destroy', [
            'as'         => 'adminevent.deletes',
            'uses'       => 'AdminEventController@deletes',
        ]);

        Route::resource('adminteam', 'AdminTeamController');
        Route::delete('adminteam/items/destroy', [
            'as'         => 'adminteam.deletes',
            'uses'       => 'AdminTeamController@deletes',
        ]);

        Route::resource('admincategory', 'AdminCategoryController');
        Route::delete('admincategory/items/destroy', [
            'as'         => 'admincategory.deletes',
            'uses'       => 'AdminCategoryController@deletes',
        ]);
        Route::put('update-tree', [
            'as' => 'admincategory.update-tree',
            'uses' => 'AdminCategoryController@updateTree',
        ]);
        Route::resource('admineducation', 'AdminEducationController');
        Route::delete('admineducation/items/destroy', [
            'as'         => 'admineducation.deletes',
            'uses'       => 'AdminEducationController@deletes',
        ]);
        Route::resource('adminnoticeboard', 'AdminNoticeBoardController');
        Route::delete('adminnoticeboard/items/destroy', [
            'as'         => 'adminnoticeboard.deletes',
            'uses'       => 'AdminNoticeBoardController@deletes',
        ]);
        Route::resource('adminpartner', 'AdminPartnerController');
        Route::delete('adminpartner/items/destroy', [
            'as'         => 'adminpartner.deletes',
            'uses'       => 'AdminPartnerController@deletes',
        ]);

        Route::resource('admintestimonial', 'AdminTestimonialController');
        Route::delete('admintestimonial/items/destroy', [
            'as'         => 'admintestimonial.deletes',
            'uses'       => 'AdminTestimonialController@deletes',
        ]);
        Route::resource('adminfacility', 'AdminFacilityController');
        Route::delete('adminfacility/items/destroy', [
            'as'         => 'adminfacility.deletes',
            'uses'       => 'AdminFacilityController@deletes',
        ]);
        Route::resource('admincareernavigator', 'AdminCareerNavigatorController');
        Route::delete('admincareernavigator/items/destroy', [
            'as'         => 'admincareernavigator.deletes',
            'uses'       => 'AdminCareerNavigatorController@deletes',
        ]);
        Route::resource('adminstudentguideline', 'AdminStudentGuidelineController');
        Route::delete('adminstudentguideline/items/destroy', [
            'as'         => 'adminstudentguideline.deletes',
            'uses'       => 'AdminStudentGuidelineController@deletes',
        ]);
        Route::resource('adminacademicgroup', 'AdminAcademicGroupController');
        Route::delete('adminacademicgroup/items/destroy', [
            'as'         => 'adminacademicgroup.deletes',
            'uses'       => 'AdminAcademicGroupController@deletes',
        ]);
        Route::resource('admingalleryboard', 'AdminGalleryBoardController');
        Route::delete('admingalleryboard/items/destroy', [
            'as'         => 'admingalleryboard.deletes',
            'uses'       => 'AdminGalleryBoardController@deletes',
        ]);
    });

    Route::post('/admin/dropzone/upload', 'AdminBoardController@uploadFile')->name('admin.dropzone.upload');
    Route::post('/admin/dropzone/delete','AdminBoardController@destroy_uploadFile')->name('admin.dropzone.delete');
    Route::get('/admin/dropzone/getimages/{id}/{model}','AdminBoardController@getImages')->name('admin.dropzone.getimages');

});


//Route::group(['namespace' => 'Modules\AdminBoard\Http\Controllers', 'middleware' => ['web']], function () {
//
//    if (defined('THEME_MODULE_SCREEN_NAME')) {
//        Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE, []), function () {
////        event(new ThemeRoutingBeforeEvent());
//            if (SlugHelper::getPrefix(AdminWorkshop::class)) {
//                Route::get(SlugHelper::getPrefix(AdminWorkshop::class) . '/{slug}', [
//                    'uses' => 'PublicController@getPage',
//                ]);
//            }
////        event(new ThemeRoutingAfterEvent());
//        });
//    }
//});
