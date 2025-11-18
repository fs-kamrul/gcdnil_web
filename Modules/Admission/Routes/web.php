<?php


Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('admission')->group(function () {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
        //    Route::get('/import', 'AdmissionController@import')->name('admission.import');
        //    Route::post('/store_import', 'AdmissionController@store_import')->name('admission.store_import');
        //    Route::get('/pdf_show/{admission}', 'AdmissionController@pdf')->name('admission.pdf_show');

    });
    //  Route::get('api/admission','AdmissionController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('admission', 'AdmissionController');
        Route::delete('admission/items/destroy', [
            'as' => 'admission.deletes',
            'uses' => 'AdmissionController@deletes',
        ]);
        Route::resource('admission/class', 'AdmissionClassController')->only(['index']);

        Route::match(['get', 'post', 'head'],'get-student-list/{class}/{year}', [
            'as' => 'get-student-list',
            'uses' => 'AdmissionClassController@getAllStudentList',
        ])->where('id', '[0-9]+');

        Route::post('update-roll-by', [
            'as' => 'update-roll-by',
            'uses' => 'AdmissionClassController@postUpdateRollby',
        ]);
        Route::get('site_plan/{class}/{year}', [
            'as' => 'site_plan',
            'uses' => 'AdmissionClassController@site_plan'
        ])->where('id', '[0-9]+');
        Route::get('merit_result/{class}/{year}', [
            'as' => 'merit_result',
            'uses' => 'AdmissionClassController@merit_result'
        ])->where('id', '[0-9]+');
//        Route::get('/admission/class', [
//            'as'    => 'admission.class',
//            'uses'  => 'AdmissionClassController@index'
//        ]);
        Route::resource('admissionsubject', 'AdmissionSubjectController');
        Route::delete('admissionsubject/items/destroy', [
            'as'         => 'admissionsubject.deletes',
            'uses'       => 'AdmissionSubjectController@deletes',
        ]);
        Route::resource('admissionmark', 'AdmissionMarkController');
        Route::delete('admissionmark/items/destroy', [
            'as'         => 'admissionmark.deletes',
            'uses'       => 'AdmissionMarkController@deletes',
        ]);
        Route::get('admissionmark/mark/{class}/{year}', [
            'as' => 'admissionmark.mark',
            'uses' => 'AdmissionMarkController@add_mark'
        ])->where('id', '[0-9]+');
        Route::resource('admissionmerit', 'AdmissionMeritController');
        Route::delete('admissionmerit/items/destroy', [
            'as'         => 'admissionmerit.deletes',
            'uses'       => 'AdmissionMeritController@deletes',
        ]);
        //student_migration
        Route::get('admissionmigration/{class}/{year}', [
            'as' => 'admissionmigration',
            'uses' => 'AdmissionMigrationController@add_migration'
        ])->where('id', '[0-9]+');
        Route::resource('admissionmigration', 'AdmissionMigrationController');
    });
});
Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE,['middleware' => ['web']]), function () {
    Route::post('admission_store/store', [
        'as' => 'admission_store.store',
        'uses' => 'AdmissionController@admission_store'
    ]);
    Route::post('admission_update/{admission}', [
        'as' => 'admission_update',
        'uses' => 'AdmissionController@admission_update'
    ]);
    Route::get('admission_show/{id}', [
        'as' => 'admission_show',
        'uses' => 'AdmissionController@admission_show'
    ]);
    Route::get('admission_payment/{id}', [
        'as' => 'admission_payment',
        'uses' => 'AdmissionController@admission_payment'
    ]);
    Route::get('admission_search/{id}', [
        'as' => 'admission_search',
        'uses' => 'AdmissionController@admission_search'
    ]);
    Route::post('admission_ssl_payment', [
        'as' => 'admission_ssl_payment',
        'uses' => 'AdmissionController@admission_ssl_payment'
    ]);
    Route::POST('admission_ssl_payment_success', [
        'as' => 'admission_ssl_payment_success',
        'uses' => 'AdmissionController@admission_ssl_payment_success'
    ]);
    Route::post('admission_ssl_payment_cancel', [
        'as' => 'admission_ssl_payment_cancel',
        'uses' => 'AdmissionController@admission_ssl_payment_cancel'
    ]);
    Route::post('admission_ssl_payment_fail', [
        'as' => 'admission_ssl_payment_fail',
        'uses' => 'AdmissionController@admission_ssl_payment_fail'
    ]);
});

