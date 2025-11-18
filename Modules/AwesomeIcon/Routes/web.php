<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('awesomeicon')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'AwesomeIconController@import')->name('awesomeicon.import');
    //    Route::post('/store_import', 'AwesomeIconController@store_import')->name('awesomeicon.store_import');
    //    Route::get('/pdf_show/{awesomeicon}', 'AwesomeIconController@pdf')->name('awesomeicon.pdf_show');
        Route::get('awesomeicon', [
            'as'         => 'themeicon.awesomeicon',
            'uses'       => 'AwesomeIconController@geticon',
        ]);
    });
  //  Route::get('api/awesomeicon','AwesomeIconController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('awesomeicon', 'AwesomeIconController');
        Route::delete('awesomeicon/items/destroy', [
            'as'         => 'awesomeicon.deletes',
            'uses'       => 'AwesomeIconController@deletes',
        ]);
    });
});

