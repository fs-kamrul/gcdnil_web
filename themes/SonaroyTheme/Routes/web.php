<?php

Route::group(['namespace' => 'Theme\SonaroyTheme\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('ajax/cart', 'SonaroyThemeController@ajaxCart')
            ->name('public.ajax.cart');

        Route::get('ajax/products', 'SonaroyThemeController@ajaxGetProducts')
            ->name('public.ajax.products');

        Route::get('ajax/product-categories/products', 'SonaroyThemeController@ajaxGetProductsByCategoryId')
            ->name('public.ajax.product-category-products');

        Route::get('ajax/featured-products', 'SonaroyThemeController@getFeaturedProducts')
            ->name('public.ajax.featured-products');

        Route::get('ajax/posts', 'SonaroyThemeController@ajaxGetPosts')->name('public.ajax.posts');

        Route::get('ajax/featured-product-categories', 'SonaroyThemeController@getFeaturedProductCategories')
            ->name('public.ajax.featured-product-categories');

        Route::get('ajax/featured-brands', 'SonaroyThemeController@ajaxGetFeaturedBrands')
            ->name('public.ajax.featured-brands');

        Route::get('ajax/related-products/{id}', 'SonaroyThemeController@ajaxGetRelatedProducts')
            ->name('public.ajax.related-products');

        Route::get('ajax/product-reviews/{id}', 'SonaroyThemeController@ajaxGetProductReviews')
            ->name('public.ajax.product-reviews');

        Route::get('ajax/get-flash-sales', 'SonaroyThemeController@ajaxGetFlashSales')
            ->name('public.ajax.get-flash-sales');

        Route::get('ajax/quick-view/{id}', 'SonaroyThemeController@getQuickView')
            ->name('public.ajax.quick-view');
    });
});

Theme::routes();
Route::group(['namespace' => 'Theme\SonaroyTheme\Http\Controllers', 'middleware' => ['web']], function () {
    Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('ajax/get-panel-inner', 'SonaroyThemeController@ajaxGetPanelInner')
            ->name('theme.ajax-get-panel-inner');

        Route::get('/', 'SonaroyThemeController@getIndex')
            ->name('public.index');
        Route::get('sitemap.xml', 'SonaroyThemeController@getSiteMap')
            ->name('public.sitemap');
        Route::get('{slug?}' . config('kamruldashboard.public_single_ending_url'), 'SonaroyThemeController@getView')
            ->name('public.single');
    });
});
