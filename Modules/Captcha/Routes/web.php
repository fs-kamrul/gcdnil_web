<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('captcha')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'CaptchaController@import')->name('captcha.import');
    //    Route::post('/store_import', 'CaptchaController@store_import')->name('captcha.store_import');
    //    Route::get('/pdf_show/{captcha}', 'CaptchaController@pdf')->name('captcha.pdf_show');

    });
  //  Route::get('api/captcha','CaptchaController@data');
//    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
//        Route::resource('captcha', 'CaptchaController');
//        Route::delete('captcha/items/destroy', [
//            'as'         => 'captcha.deletes',
//            'uses'       => 'CaptchaController@deletes',
//        ]);
//    });
});

