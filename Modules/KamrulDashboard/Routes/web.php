<?php
Auth::routes();
Route::get('login/', 'LoginController@showLoginForm')->name('login');
Route::post('login/', 'LoginController@login')->name('login.post');
Route::post('logout/', 'LoginController@logout')->name('logout');
Route::get('register/', 'RegisterController@showRegistrationForm')->name('register');
Route::post('register/', 'RegisterController@register')->name('register.store');
Route::get('password/reset/', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email/', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset/', 'ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::get('password/confirm/', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm/', 'ConfirmPasswordController@confirm');


//if(env('DB_DATABASE')=='')
//{
//    Route::get('/', 'InstallatationController@index');
//    Route::get('/install', 'InstallatationController@index');
//    Route::get('/update-details', 'InstallatationController@updateDetails');
//    Route::post('/install', 'InstallatationController@installProject');
//}

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {

    Route::get('dashboard', [
        'uses'       => 'DashboardsController@index',
    ]);
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::group(['middleware' => ['\Modules\KamrulDashboard\Http\Middleware\DboardMiddleware']], function () {
//            Route::resources([
//                'dashboard' => 'DashboardsController',
//            ]);
            Route::get('', [
                'as'         => 'dashboard.index',
                'uses'       => 'DashboardsController@index',
            ]);
        });
        //Plugins
        Route::resources([
            'plugins' => 'PluginsController',
        ]);
        Route::group(['prefix' => 'slug'], function () {
            Route::post('create', [
                'as'   => 'slug.create',
                'uses' => 'SlugController@store',
            ]);
        });
    });
//settings
//    Route::resource('settings', 'SettingController');
//
//    Route::delete('settings/items/destroy', [
//        'as'         => 'setting.deletes',
//        'uses'       => 'SettingController@deletes',
//    ]);
    Route::get('systemsettings/settings/', 'SettingController@index');
    Route::get('systemsettings/settings/index', 'SettingController@index');
    Route::get('systemsettings/settings/add', 'SettingController@create');
    Route::post('systemsettings/settings/add', 'SettingController@store');
    Route::get('systemsettings/settings/edit/{slug}', 'SettingController@edit');
    Route::patch('systemsettings/settings/edit/{slug}', 'SettingController@update');
    Route::get('systemsettings/settings/view/{slug}', 'SettingController@viewSettings');
    Route::get('systemsettings/settings/add-sub-settings/{slug}', 'SettingController@addSubSettings');
    Route::post('systemsettings/settings/add-sub-settings/{slug}', 'SettingController@storeSubSettings');
    Route::patch('systemsettings/settings/add-sub-settings/{slug}', 'SettingController@updateSubSettings');
//
    Route::post('systemsettings/settings/add-ajax-data', 'SettingController@addajax');
    Route::get('systemsettings/settings/getList', [ 'as'   => 'systemsettings.dataTable', 'uses' => 'SettingController@data']);

    Route::post('upload-plugin', 'PluginsController@uploadPlugin');
    Route::get('plugin-active/{module}', 'PluginsController@plugin_active');

});

///------------------------------------------------------------------------------

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('kamruldashboard')->group(function () {
        //Install
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
        Route::get('/import', 'KamrulDashboardController@import')->name('kamruldashboard.import');
        Route::post('/store_import', 'KamrulDashboardController@store_import')->name('kamruldashboard.store_import');
        Route::get('/pdf_show/{kamruldashboard}', 'KamrulDashboardController@pdf')->name('kamruldashboard.pdf_show');

    });
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::prefix('kamruldashboard')->group(function () {
            //Backup
            Route::get('backup/download/{file_name}', 'BackUpController@download');
            Route::get('backup/delete/{file_name}', 'BackUpController@delete');
    //        Route::resource('backup', 'BackUpController', ['only' => [
    //            'index', 'create', 'store'
    //        ]]);
            Route::get('backup', [
                'as'   => 'kamruldashboard.backup',
                'uses' => 'BackUpController@getIndex',
            ]);
            Route::post('backup/create', [
                'as'         => 'kamruldashboard.backups.create',
                'uses'       => 'BackUpController@store',
            ]);
            Route::delete('delete/{folder}', [
                'as'         => 'kamruldashboard.backups.destroy',
                'uses'       => 'BackUpController@destroy',
            ]);

            Route::get('restore/{folder}', [
                'as'   => 'kamruldashboard.backups.restore',
                'uses' => 'BackUpController@getRestore',
            ]);
            Route::get('download-database/{folder}', [
                'as'         => 'kamruldashboard.backups.download.database',
                'uses'       => 'BackUpController@getDownloadDatabase',
            ]);
            Route::get('download-uploads-folder/{folder}', [
                'as'         => 'kamruldashboard.backups.download.uploads.folder',
                'uses'       => 'BackUpController@getDownloadUploadFolder',
            ]);
            //cache_management
            Route::group(['prefix' => 'system/cache'], function () {

                Route::get('', [
                    'as'         => 'system.cache',
                    'uses'       => 'SystemsController@getCacheManagement',
                    'permission' => false,
                ]);

                Route::post('clear', [
                    'as'         => 'system.cache.clear',
                    'uses'       => 'SystemsController@postClearCache',
                    'permission' => false,
                ]);
            });
//-----------------------------------------------User Controller--------------------------------------------------------
//            Route::get('/api/user', 'UserController@data');
//            Route::get('/user/import', 'UserController@import');
//            Route::post('/user/store_import', 'UserController@store_import');
//            Route::get('/user/pdf_show/{user}', 'UserController@pdf');
            Route::get('/user/change_password/{user}', 'UserController@change_password');
            Route::patch('/user/change_password/{user}', 'UserController@password_update');

            Route::get('/user/change_password/{user}', [
                'as'         => 'user.change_password',
                'uses'       => 'UserController@change_password',
            ]);
            Route::patch('/user/change_password/{user}', [
                'as'         => 'user.password_update',
                'uses'       => 'UserController@password_update',
            ]);
            Route::get('/user/pdf/{user}',[
                'as'         => 'user.pdf',
                'uses' => 'UserController@pdf',
            ]);
            Route::resource('user', 'UserController');
            Route::delete('user/items/destroy', [
                'as'         => 'user.deletes',
                'uses'       => 'UserController@deletes',
            ]);

//-----------------------------------------------Role Controller--------------------------------------------------------
//            Route::get('/api/role', 'RoleController@data');
//            Route::get('/role/import', 'RoleController@import');
//            Route::post('/role/store_import', 'RoleController@store_import');
//            Route::get('/role/pdf_show/{role}', 'RoleController@pdf');
//            Route::resource('role', 'RoleController');
            Route::resource('role', 'RoleController');

            Route::delete('role/items/destroy', [
                'as'         => 'role.deletes',
                'uses'       => 'RoleController@deletes',
            ]);

//---------------------------------------------Permission Controller----------------------------------------------------
//            Route::get('/permission/import', [
//                'as'         => 'permission.import',
//                'uses'       => 'PermissionController@import',
//            ]);
//            Route::post('/permission/store_import', [
//                'as'         => 'permission.store_import',
//                'uses'       => 'PermissionController@store_import',
//            ]);
            Route::resource('permission', 'PermissionController');

            Route::delete('permission/items/destroy', [
                'as'         => 'permission.deletes',
                'uses'       => 'PermissionController@deletes',
            ]);

        });
        Route::group(['prefix' => 'settings'], function () {
            Route::get('general', [
                'as' => 'settings.options',
                'uses' => 'SettingDataController@getOptions',
                'permission' => 'settings.options',
            ]);

            Route::post('general/edit', [
                'as' => 'settings.edit',
                'uses' => 'SettingDataController@postEdit',
                'permission' => 'settings.options',
            ]);

            Route::group(['prefix' => 'email', 'permission' => 'settings.email'], function () {
                Route::get('', [
                    'as' => 'settings.email',
                    'uses' => 'SettingDataController@getEmailConfig',
                ]);

                Route::match(['POST', 'GET'], 'templates/preview/{type}/{module}/{template}', [
                    'as' => 'setting.email.preview',
                    'uses' => 'SettingDataController@previewEmailTemplate',
                ]);

                Route::get('templates/preview/{type}/{module}/{template}/iframe', [
                    'as' => 'setting.email.preview.iframe',
                    'uses' => 'SettingDataController@previewEmailTemplateIframe',
                ]);

                Route::post('edit', [
                    'as' => 'settings.email.edit',
                    'uses' => 'SettingDataController@postEditEmailConfig',
                ]);

                Route::get('templates/edit/{type}/{module}/{template}', [
                    'as' => 'setting.email.template.edit',
                    'uses' => 'SettingDataController@getEditEmailTemplate',
                ]);

                Route::post('template/edit', [
                    'as' => 'setting.email.template.store',
                    'uses' => 'SettingDataController@postStoreEmailTemplate',
                    'middleware' => 'preventDemo',
                ]);

                Route::post('template/reset-to-default', [
                    'as' => 'setting.email.template.reset-to-default',
                    'uses' => 'SettingDataController@postResetToDefault',
                    'middleware' => 'preventDemo',
                ]);

                Route::post('status', [
                    'as' => 'setting.email.status.change',
                    'uses' => 'SettingDataController@postChangeEmailStatus',
                ]);

                Route::post('test/send', [
                    'as' => 'setting.email.send.test',
                    'uses' => 'SettingDataController@postSendTestEmail',
                ]);
            });

            Route::get('cronjob', [
                'as' => 'settings.cronjob',
                'uses' => 'SettingDataController@cronjob',
                'permission' => 'settings.cronjob',
            ]);
        });
//-------------------------------------------kamruldashboard Controller-------------------------------------------------
    //    Route::get('api/kamruldashboard','KamrulDashboardController@data');
        Route::resource('kamruldashboard', 'KamrulDashboardController');
    });
});

Route::get('/data-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('optimize');
    return 'Cache All view,route,config Data';
});
