<?php

use Modules\SocialLogin\Facades\SocialServiceFacade;

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('sociallogin')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'SocialLoginController@import')->name('sociallogin.import');
    //    Route::post('/store_import', 'SocialLoginController@store_import')->name('sociallogin.store_import');
    //    Route::get('/pdf_show/{sociallogin}', 'SocialLoginController@pdf')->name('sociallogin.pdf_show');

    });
  //  Route::get('api/sociallogin','SocialLoginController@data');
//    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
//        Route::resource('sociallogin', 'SocialLoginController');
//        Route::delete('sociallogin/items/destroy', [
//            'as'         => 'sociallogin.deletes',
//            'uses'       => 'SocialLoginController@deletes',
//        ]);
//    });
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['prefix' => DboardHelper::getAdminPrefix(), 'middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
        Route::group(['prefix' => 'social-login'], function () {
            Route::get('settings', [
                'as' => 'social-login.settings',
                'uses' => 'SocialLoginController@getSettings',
            ]);

            Route::post('settings', [
                'as' => 'social-login.settings.post',
                'uses' => 'SocialLoginController@postSettings',
            ]);
        });
    });

    $providers = collect(SocialServiceFacade::getProviderKeys())->implode('|');

    Route::get('auth/{provider}', [
        'as' => 'auth.social',
        'uses' => 'SocialLoginController@redirectToProvider',
    ])->where('provider', $providers);

    Route::get('auth/callback/{provider}', [
        'as' => 'auth.social.callback',
        'uses' => 'SocialLoginController@handleProviderCallback',
    ])->where('provider', $providers);
});
