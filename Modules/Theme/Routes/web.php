<?php

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('theme')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
//        Route::get('/import', 'ThemeController@import')->name('theme.import');
//        Route::post('/store_import', 'ThemeController@store_import')->name('theme.store_import');
//        Route::get('/pdf_show/{theme}', 'ThemeController@pdf')->name('theme.pdf_show');
        Route::get('all', [
            'as'   => 'theme.index',
            'uses' => 'ThemeController@index',
        ]);
        Route::post('active', [
            'as'         => 'theme.active',
            'uses'       => 'ThemeController@postActivateTheme',
        ]);
        Route::post('remove', [
            'as'         => 'theme.remove',
            'uses'       => 'ThemeController@postRemoveTheme',
        ]);
        Route::get('clear_cache', [
            'as'         => 'theme.clear_cache',
            'uses'       => 'ThemeController@clear_cache',
        ]);
    });
//    Route::get('api/theme','ThemeController@data');
//    Route::resource('theme', 'ThemeController');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::group(['prefix' => 'theme/setting'], function () {
            Route::get('', [
                'as'   => 'theme.options',
                'uses' => 'ThemeController@getOptions',
            ]);
            Route::post('', [
                'as'         => 'theme.options.post',
                'uses'       => 'ThemeController@postUpdate',
//                'permission' => 'theme.options',
            ]);
        });
    });
});

