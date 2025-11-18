<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('shortcodes')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
//        Route::get('/import', 'ShortcodesController@import')->name('shortcodes.import');
//        Route::post('/store_import', 'ShortcodesController@store_import')->name('shortcodes.store_import');
//        Route::get('/pdf_show/{shortcode}', 'ShortcodesController@pdf')->name('shortcodes.pdf_show');

        Route::post('/shortcode/dropzone_upload/{type}', 'ShortcodesController@uploadFile')->name('shortcode.dropzone_upload');
        Route::post('/shortcode/dropzone_delete','ShortcodesController@destroy_uploadFile')->name('shortcode.dropzone_delete');
        Route::get('/shortcode/dropzone_getimages/{id}','ShortcodesController@getImages')->name('shortcode.dropzone_getimages');
    });
//    Route::get('api/shortcodes','ShortcodesController@data');
//    Route::resource('shortcodes', 'ShortcodesController');

    Route::group(['prefix' => 'short-codes'], function () {
        Route::get('ajax-get-admin-config/{key}', [
            'as'         => 'short-codes.ajax-get-admin-config',
            'uses'       => 'ShortcodesController@ajaxGetAdminConfig',
            'permission' => false,
        ]);
    });
});

