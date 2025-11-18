<?php
Route::group(['middleware' => ['auth', '\Modules\KamrulDashboard\Http\Middleware\IsInstalled', '\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu']], function () {
    Route::prefix('post')->group(function() {
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
    });
    Route::group(['prefix' => DboardHelper::getAdminPrefix()], function () {
    Route::prefix('post')->group(function() {
//-------------------------------------------Page Template Controller---------------------------------------------------
        Route::get('/pagetemplate/import', [
            'as'         => 'pagetemplate.import',
            'uses'       => 'PageTemplateController@import',
        ]);
        Route::post('/pagetemplate/store_import', [
            'as'         => 'pagetemplate.store_import',
            'uses'       => 'PageTemplateController@store_import',
        ]);
        Route::get('/pagetemplate/pdf_show/{category}', [
            'as'         => 'pagetemplate.pdf_show',
            'uses'       => 'PageTemplateController@pdf',
        ]);
        Route::resource('pagetemplate', 'PageTemplateController');

        Route::delete('pagetemplate/items/destroy', [
            'as'         => 'pagetemplate.deletes',
            'uses'       => 'PageTemplateController@deletes',
        ]);
//-----------------------------------------------Page Controller--------------------------------------------------------
        Route::get('page/import', [
            'as'         => 'post.page.import',
            'uses'       => 'PageController@import',
        ]);
        Route::get('/page/pdf_show/{page}', [
            'as'         => 'post.page.pdf_show',
            'uses'       => 'PageController@pdf',
        ]);
        Route::resource('page', 'PageController');
        Route::delete('items/destroy', [
            'as'         => 'page.deletes',
            'uses'       => 'PageController@deletes',
        ]);
//-----------------------------------------------Page Type Controller---------------------------------------------------
//        Route::get('/api/posttype','PostTypeController@data');
//        Route::post('/posttype/store_import', 'PostTypeController@store_import');
//        Route::get('/posttype/import', 'PostTypeController@import');
//        Route::get('/posttype/pdf_show/{posttype}', 'PostTypeController@pdf');
        Route::get('/posttype/import', [
            'as'         => 'posttype.import',
            'uses'       => 'PostTypeController@import',
        ]);
        Route::get('/posttype/pdf_show/{posttype}', [
            'as'         => 'posttype.pdf_show',
            'uses'       => 'PostTypeController@pdf',
        ]);
        Route::resource('posttype', 'PostTypeController');

        Route::delete('posttype/items/destroy', [
            'as'         => 'posttype.deletes',
            'uses'       => 'PostTypeController@deletes',
        ]);
//-----------------------------------------------Category Controller----------------------------------------------------
        Route::post('/category/store_import', [
            'as'         => 'category.store_import',
            'uses'       => 'CategoryController@store_import',
        ]);
        Route::get('/category/import', [
            'as'         => 'category.import',
            'uses'       => 'CategoryController@import',
        ]);
        Route::get('/category/pdf_show/{category}', [
            'as'         => 'category.pdf_show',
            'uses'       => 'CategoryController@pdf',
        ]);
        Route::resource('category', 'CategoryController');

        Route::delete('category/items/destroy', [
            'as'         => 'category.deletes',
            'uses'       => 'CategoryController@deletes',
        ]);

//-----------------------------------------------Post Controller--------------------------------------------------------
//        Route::get('/import', 'PostController@import')->name('post.import');
//        Route::post('/store_import', 'PostController@store_import')->name('post.store_import');
//        Route::get('/pdf_show/{post}', 'PostController@pdf')->name('post.pdf_show');

        Route::get('/import', [
            'as'         => 'post.import',
            'uses'       => 'PostController@import',
        ]);
        Route::post('/store_import', [
            'as'         => 'post.store_import',
            'uses'       => 'PostController@store_import',
        ]);
        Route::get('/pdf_show/{post}', [
            'as'         => 'post.pdf_show',
            'uses'       => 'PostController@pdf',
        ]);

        Route::post('/dropzone/upload', 'PostController@uploadFile')->name('post.dropzone.upload');
        Route::post('/dropzone/delete','PostController@destroy_uploadFile')->name('post.dropzone.delete');
        Route::get('/dropzone/getimages/{id}','PostController@getImages')->name('post.dropzone.getimages');

    });
    Route::resource('post', 'PostController');
    });
    Route::delete('post/items/destroy', [
        'as'         => 'post.deletes',
        'uses'       => 'PostController@deletes',
    ]);
    Route::prefix('post')->group(function() {

//        Route::get('/api/pagetemplate','PageTemplateController@data');
//        Route::get('/api/page','PageController@data');
//        Route::get('/api/posttype','PostTypeController@data');
//        Route::get('/api/category','CategoryController@data');
    });
//    Route::get('api/post','PostController@data');
});

