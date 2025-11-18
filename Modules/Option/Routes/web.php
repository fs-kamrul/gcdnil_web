<?php



//Route::get('/get-set-subjects/{class_id}', [\Modules\Option\Http\Controllers\OptionSetController::class, 'getSetSubjects'])->name('getSetSubjects');
Route::get('/get-set-subjects/{class_id}/{group_id}', [\Modules\Option\Http\Controllers\OptionSetController::class, 'getSetSubjects']);


Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {

        Route::resource('optionbloodgroup', 'OptionBloodGroupController');
        Route::delete('optionbloodgroup/items/destroy', [
            'as'         => 'optionbloodgroup.deletes',
            'uses'       => 'OptionBloodGroupController@deletes',
        ]);

        Route::resource('optionset', 'OptionSetController');
        Route::delete('optionset/items/destroy', [
            'as'         => 'optionset.deletes',
            'uses'       => 'OptionSetController@deletes',
        ]);

        Route::resource('optiongender', 'OptionGenderController');
        Route::delete('optiongender/items/destroy', [
            'as'         => 'optiongender.deletes',
            'uses'       => 'OptionGenderController@deletes',
        ]);
        Route::resource('optionreligion', 'OptionReligionController');
        Route::delete('optionreligion/items/destroy', [
            'as'         => 'optionreligion.deletes',
            'uses'       => 'OptionReligionController@deletes',
        ]);
        Route::resource('optionsection', 'OptionSectionController');
        Route::delete('optionsection/items/destroy', [
            'as'         => 'optionsection.deletes',
            'uses'       => 'OptionSectionController@deletes',
        ]);
        Route::resource('optiongroup', 'OptionGroupController');
        Route::delete('optiongroup/items/destroy', [
            'as'         => 'optiongroup.deletes',
            'uses'       => 'OptionGroupController@deletes',
        ]);
        Route::resource('optionyear', 'OptionYearController');
        Route::delete('optionyear/items/destroy', [
            'as'         => 'optionyear.deletes',
            'uses'       => 'OptionYearController@deletes',
        ]);
        Route::resource('optionclass', 'OptionClassController');
        Route::delete('optionclass/items/destroy', [
            'as'         => 'optionclass.deletes',
            'uses'       => 'OptionClassController@deletes',
        ]);
        Route::resource('optionsubject', 'OptionSubjectController');
        Route::delete('optionsubject/items/destroy', [
            'as'         => 'optionsubject.deletes',
            'uses'       => 'OptionSubjectController@deletes',
        ]);
    });
});
?>
<?php



Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('option')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    //    Route::get('/import', 'OptionController@import')->name('option.import');
    //    Route::post('/store_import', 'OptionController@store_import')->name('option.store_import');
    //    Route::get('/pdf_show/{option}', 'OptionController@pdf')->name('option.pdf_show');

    });
  //  Route::get('api/option','OptionController@data');
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
        Route::resource('option', 'OptionController');
        Route::delete('option/items/destroy', [
            'as'         => 'option.deletes',
            'uses'       => 'OptionController@deletes',
        ]);
    });
});

