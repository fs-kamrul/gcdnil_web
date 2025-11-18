<?php



//Route::group(['middleware' => ['web']], function () {
//    Route::get('/', [
//        'as'   => 'public.index',
//        'uses' => 'PublicController@getIndex',
//    ]);
//});

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('sitemap')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    });
});

