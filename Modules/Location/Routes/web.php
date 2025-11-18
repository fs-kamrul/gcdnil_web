
<?php
Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('location')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');

    });
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('country', 'CountryController');
        Route::delete('country/items/destroy', [
            'as'         => 'country.deletes',
            'uses'       => 'CountryController@deletes',
        ]);
        Route::resource('state', 'StateController');
        Route::delete('state/items/destroy', [
            'as'         => 'state.deletes',
            'uses'       => 'StateController@deletes',
        ]);
        Route::resource('city', 'CityController');
        Route::delete('city/items/destroy', [
            'as'         => 'city.deletes',
            'uses'       => 'CityController@deletes',
        ]);
    });
//    Route::get('ajax/states-by-country', 'StateController@ajaxGetStates')
//        ->name('ajax.states-by-country');
//    Route::get('ajax/cities-by-state', 'CityController@ajaxGetCities')
//        ->name('ajax.cities-by-state');
});

Route::group(['middleware' => ['web']], function () {

    Route::get('ajax/states-by-country', 'StateController@ajaxGetStates')
        ->name('ajax.states-by-country');
    Route::get('ajax/cities-by-state', 'CityController@ajaxGetCities')
        ->name('ajax.cities-by-state');
});
