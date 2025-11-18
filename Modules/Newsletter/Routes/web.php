<?php

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('newsletter')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
//        Route::get('/import', 'NewsletterController@import')->name('newsletter.import');
//        Route::post('/store_import', 'NewsletterController@store_import')->name('newsletter.store_import');
//        Route::get('/pdf_show/{newsletter}', 'NewsletterController@pdf')->name('newsletter.pdf_show');
    });
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
//        Route::get('api/newsletter', 'NewsletterController@data');
        Route::resource('newsletter', 'NewsletterController');
        Route::delete('newsletter/items/destroy', [
            'as' => 'newsletter.deletes',
            'uses' => 'NewsletterController@deletes',
        ]);
    });
});
Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE, []), function () {
    Route::group(['middleware' => ['web']], function () {
        Route::post('newsletter/subscribe', [
            'as'   => 'public.newsletter.subscribe',
            'uses' => 'PublicController@postSubscribe',
        ]);
//        Route::get('newsletter/unsubscribe/{email}', [
//            'as'   => 'public.newsletter.unsubscribe',
//            'uses' => 'PublicController@getUnsubscribe',
//        ]);
        Route::get('newsletter/unsubscribe/{user}', [
            'as' => 'public.newsletter.unsubscribe',
            'uses' => 'PublicController@getUnsubscribe',
        ]);
    });
});
