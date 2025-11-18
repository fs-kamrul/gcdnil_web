<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::prefix('language')->group(function() {
            Route::get('/install', 'InstallController@index');
            Route::get('/install/update', 'InstallController@update');
            Route::get('/install/uninstall', 'InstallController@uninstall');
            Route::group(['prefix' => 'settings/languages'], function () {
                Route::get('', [
                    'as'   => 'languages.index',
                    'uses' => 'LanguageController@index',
                ]);

                Route::post('store', [
                    'as'         => 'languages.store',
                    'uses'       => 'LanguageController@postStore',
                ]);

                Route::post('edit', [
                    'as'         => 'languages.edit',
                    'uses'       => 'LanguageController@update',
                ]);

                Route::delete('delete/{id}', [
                    'as'         => 'languages.destroy',
                    'uses'       => 'LanguageController@destroy',
                ]);

                Route::get('set-default', [
                    'as'         => 'languages.set.default',
                    'uses'       => 'LanguageController@getSetDefault',
                ]);

                Route::get('get', [
                    'as'         => 'languages.get',
                    'uses'       => 'LanguageController@getLanguage',
                ]);

                Route::post('edit-setting', [
                    'as'         => 'languages.settings',
                    'uses'       => 'LanguageController@postEditSettings',
                ]);
            });
        });
    });
    Route::group(['prefix' => 'languages'], function () {

        Route::post('change-item-language', [
            'as'         => 'languages.change.item.language',
            'uses'       => 'LanguageController@postChangeItemLanguage',
        ]);

        Route::get('change-data-language/{locale}', [
            'as'         => 'languages.change.data.language',
            'uses'       => 'LanguageController@getChangeDataLanguage',
        ]);
    });
});

