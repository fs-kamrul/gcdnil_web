<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('simpleslider')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'SimpleSliderController@import')->name('simpleslider.import');
    //    Route::post('/store_import', 'SimpleSliderController@store_import')->name('simpleslider.store_import');
    //    Route::get('/pdf_show/{simpleslider}', 'SimpleSliderController@pdf')->name('simpleslider.pdf_show');

    });
  //  Route::get('api/simpleslider','SimpleSliderController@data');
//    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
//        Route::resource('simpleslider', 'SimpleSliderController');
//        Route::delete('simpleslider/items/destroy', [
//            'as'         => 'simpleslider.deletes',
//            'uses'       => 'SimpleSliderController@deletes',
//        ]);
//    });
    Route::group(['prefix' => DboardHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'simple-sliders', 'as' => 'simple-slider.'], function () {
            Route::resource('', 'SimpleSliderController')->parameters(['' => 'simple-slider']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'SimpleSliderController@deletes',
                'permission' => 'simpleslider_destroy',
            ]);

            Route::post('sorting', [
                'as' => 'sorting',
                'uses' => 'SimpleSliderController@postSorting',
                'permission' => 'simpleslider_edit',
            ]);
        });

    });
});
Route::group(['prefix' => DboardHelper::getAdminPrefix(), 'middleware' => 'web'], function () {
    Route::group(['prefix' => 'simple-slider-items', 'as' => 'simple-slider-item.'], function () {
        Route::resource('', 'SimpleSliderItemController')->except([
            'index',
            'destroy',
        ])->parameters(['' => 'simple-slider-item']);

        Route::match(['GET', 'POST'], 'list/{id}', [
            'as' => 'index',
            'uses' => 'SimpleSliderItemController@index',
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as' => 'destroy',
            'uses' => 'SimpleSliderItemController@destroy',
        ])->where('id', '[0-9]+');

        Route::delete('delete/{id}', [
            'as' => 'delete.post',
            'uses' => 'SimpleSliderItemController@postDelete',
            'permission' => 'simple-slider-item.destroy',
        ])->where('id', '[0-9]+');
    });
});

