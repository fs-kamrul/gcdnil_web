<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::prefix('widget')->group(function() {
            Route::get('/install', 'InstallController@index');
            Route::get('/install/update', 'InstallController@update');
            Route::get('/install/uninstall', 'InstallController@uninstall');
            Route::prefix('setting')->group(function() {
                Route::get('load-widget', 'WidgetController@showWidget');
                Route::get('', [
                    'as'   => 'widgets.index',
                    'uses' => 'WidgetController@index',
                ]);

                Route::post('save-widgets-to-sidebar', [
                    'as'         => 'widgets.save_widgets_sidebar',
                    'uses'       => 'WidgetController@postSaveWidgetToSidebar',
                    'permission' => 'widgets.index',
                ]);

                Route::delete('delete', [
                    'as'         => 'widgets.destroy',
                    'uses'       => 'WidgetController@postDelete',
                    'permission' => 'widgets.index',
                ]);
            });
        });
    });
});

