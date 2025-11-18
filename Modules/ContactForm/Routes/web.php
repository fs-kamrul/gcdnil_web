<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('contactform')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
//        Route::get('/import', 'ContactFormController@import')->name('contactform.import');
//        Route::post('/store_import', 'ContactFormController@store_import')->name('contactform.store_import');
//        Route::get('/pdf_show/{contactform}', 'ContactFormController@pdf')->name('contactform.pdf_show');

    });
//    Route::get('api/contactform','ContactFormController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('contactform', 'ContactFormController');
        Route::delete('contactform/items/destroy', [
            'as' => 'contactform.deletes',
            'uses' => 'ContactFormController@deletes',
        ]);
        Route::group(['prefix' => 'contactform', 'as' => 'contactform.'], function () {
            Route::post('reply/{id}', [
                'as' => 'reply',
                'uses' => 'ContactFormController@postReply',
                'permission' => 'contactform_edit',
            ])->where('id', '[0-9]+');
        });
    });
});

Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE,['middleware' => ['web']]), function () {
    Route::post('contact/send', [
        'as'   => 'public.send.contact',
        'uses' => 'PublicController@postSendContact',
    ]);
});

