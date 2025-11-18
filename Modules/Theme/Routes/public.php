<?php
use Modules\Theme\Events\ThemeRoutingBeforeEvent;
use Modules\Theme\Events\ThemeRoutingAfterEvent;
use Illuminate\Support\Facades\Route;
//use SlugHelper;


Route::group(['namespace' => 'Modules\Theme\Http\Controllers', 'middleware' => ['web']], function () {
    Route::group(apply_filters(FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        event(new ThemeRoutingBeforeEvent());
        Route::get('/', [
            'as'   => 'public.index',
            'uses' => 'PublicController@getIndex',
        ]);
        Route::get('brochure/{id}', [
            'as'   => 'brochure.page',
            'uses' => 'PublicController@brochure_page',
        ]);
//        Route::get('{key}.{extension}', 'PublicController@getSiteMapIndex')
//            ->where('key', '^' . collect(SiteMapManager::getKeys())->map(fn ($item) => '(?:' . $item . ')')->implode('|') . '$')
//            ->whereIn('extension', SiteMapManager::allowedExtensions())
//            ->name('public.sitemap.index');

        Route::get('sitemap.xml', [
            'as'   => 'public.sitemap',
            'uses' => 'PublicController@getSiteMap',
        ]);
        Route::get('{slug?}' . config('kamruldashboard.public_single_ending_url'), [
            'as'   => 'public.single',
            'uses' => 'PublicController@getView',
        ]);

//        Route::get('{prefix}/{slug?}', 'PublicController@getViewWithPrefix')
//            ->whereIn('prefix', SlugHelper::getAllPrefixes() ?: ['1437bcd2-d94e-4a5fd-9a39-b5d60225e9af']);

        Route::get('{prefix}/{slug?}', [
//            'as'   => 'public.single',
            'uses' => 'PublicController@getViewWithPrefix',
        ]);
//            ->whereIn('prefix', SlugHelper::getAllPrefixes() ?: ['1437bcd2-d94e-4a5fd-9a39-b5d60225e9af']);

        event(new ThemeRoutingAfterEvent());
    });
});
