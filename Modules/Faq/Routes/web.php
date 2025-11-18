
<?php

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('faq')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'FaqController@import')->name('faq.import');
    //    Route::post('/store_import', 'FaqController@store_import')->name('faq.store_import');
    //    Route::get('/pdf_show/{faq}', 'FaqController@pdf')->name('faq.pdf_show');

    });
  //  Route::get('api/faq','FaqController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('faq', 'FaqController');
        Route::delete('faq/items/destroy', [
            'as'         => 'faq.deletes',
            'uses'       => 'FaqController@deletes',
        ]);

        Route::resource('faqcategory', 'FaqCategoryController');
        Route::delete('faqcategory/items/destroy', [
            'as'         => 'faqcategory.deletes',
            'uses'       => 'FaqCategoryController@deletes',
        ]);
    });
});

