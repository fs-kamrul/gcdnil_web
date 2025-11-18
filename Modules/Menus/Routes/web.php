<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('menus')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
//        Route::get('/import', 'MenusController@import')->name('menus.import');
//        Route::post('/store_import', 'MenusController@store_import')->name('menus.store_import');
//        Route::get('/pdf_show/{menu}', 'MenusController@pdf')->name('menus.pdf_show');
    });

    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::prefix('menus')->group(function () {
            /**
             * menu items
             */
            Route::post('add-item', array(
                'as' => 'menus.add-item',
                'uses' => 'MenusController@createItem'
            ));
            Route::post('delete-item', array(
                'as' => 'menus.delete-item',
                'uses' => 'MenusController@destroyItem'
            ));
            Route::post('update-item', array(
                'as' => 'menus.update-item',
                'uses' => 'MenusController@updateItem'
            ));
            /**
             * menu
             */
            Route::get('menu', array(
                'as' => 'menus.menu',
                'uses' => 'MenusController@newMenu'
            ));
            Route::post('create-menu', array(
                'as' => 'menus.create-menu',
                'uses' => 'MenusController@createNewMenu'
            ));
            Route::post('delete-menu', array(
                'as' => 'menus.delete-menu',
                'uses' => 'MenusController@destroyMenu'
            ));
            Route::post('update-menu-and-items', array(
                'as' => 'menus.update-menu-and-items',
                'uses' => 'MenusController@generateMenuControl'
            ));
        });
        //    Route::get('api/menus','MenusController@data');
        Route::resource('menus', 'MenusController');
        Route::delete('menus/items/destroy', [
            'as' => 'menus.deletes',
            'uses' => 'MenusController@deletes',
        ]);
    });
});

