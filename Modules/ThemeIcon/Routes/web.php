<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('themeicon')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
        Route::get('/import', 'ThemeIconController@import')->name('themeicon.import');
        Route::post('/store_import', 'ThemeIconController@store_import')->name('themeicon.store_import');
        Route::get('/pdf_show/{themeicon}', 'ThemeIconController@pdf')->name('themeicon.pdf_show');
        Route::get('geticon', [
            'as'         => 'themeicon.geticon',
            'uses'       => 'ThemeIconController@geticon',
        ]);

    });
    Route::get('api/themeicon','ThemeIconController@data');
    Route::resource('admin/themeicon', 'ThemeIconController');
});

