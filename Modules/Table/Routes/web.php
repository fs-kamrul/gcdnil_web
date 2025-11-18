<?php

use Modules\Table\Http\Controllers\TableController;

Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('table')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');

    });

    Route::group([
        'middleware' => ['web', 'auth'],
        'prefix' => DboardHelper::getAdminPrefix() . '/tables',
        'permission' => false,
    ], function () {
        Route::get('bulk-change/data', [TableController::class, 'getDataForBulkChanges'])->name('tables.bulk-change.data');
        Route::post('bulk-change/save', [TableController::class, 'postSaveBulkChange'])->name('tables.bulk-change.save');
        Route::get('get-filter-input', [TableController::class, 'getFilterInput'])->name('tables.get-filter-input');
    });

});

