<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('languageadvanced')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');

    });
//    Route::resource('languageadvanced', 'LanguageAdvancedController');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::group(['prefix' => 'language-advanced'], function () {
            Route::post('save/{id}', [
                'as'         => 'language-advanced.save',
                'uses'       => 'LanguageAdvancedController@save',
                'permission' => false,
            ]);
        });
    });
});

