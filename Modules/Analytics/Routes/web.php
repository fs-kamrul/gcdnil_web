<?php

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('analytics')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    });
    Route::group(['prefix' => 'analytics'], function () {
        Route::get('general', [
            'as'   => 'analytics.general',
            'uses' => 'AnalyticsController@getGeneral',
        ]);
        Route::get('page', [
            'as'   => 'analytics.page',
            'uses' => 'AnalyticsController@getTopVisitPages',
        ]);
        Route::get('browser', [
            'as'   => 'analytics.browser',
            'uses' => 'AnalyticsController@getTopBrowser',
        ]);
        Route::get('referrer', [
            'as'   => 'analytics.referrer',
            'uses' => 'AnalyticsController@getTopReferrer',
        ]);
    });
});

