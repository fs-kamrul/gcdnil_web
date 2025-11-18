<?php
Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('keyfacility', 'KeyFacilityController');
        Route::delete('keyfacility/items/destroy', [
            'as'         => 'keyfacility.deletes',
            'uses'       => 'KeyFacilityController@deletes',
        ]);
    });
});
?>
<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('venuefacility')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'VenueFacilityController@import')->name('venuefacility.import');
    //    Route::post('/store_import', 'VenueFacilityController@store_import')->name('venuefacility.store_import');
    //    Route::get('/pdf_show/{venuefacility}', 'VenueFacilityController@pdf')->name('venuefacility.pdf_show');

    });
  //  Route::get('api/venuefacility','VenueFacilityController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('venuefacility', 'VenueFacilityController');
        Route::delete('venuefacility/items/destroy', [
            'as'         => 'venuefacility.deletes',
            'uses'       => 'VenueFacilityController@deletes',
        ]);
    });
});

