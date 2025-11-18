<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Page;
use Modules\Post\Http\Models\Post;

class DataController  extends Controller
{

    /**
     * Adds Post menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
//                if(auth()->user()->can('post_access')) {
//                    $menu->url(
//                        action('\Modules\Post\Http\Controllers\PostController@index'),
//                        __('post::lang.post'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); } //next_lint
                if(auth()->user()->can('post_access') ||
                    auth()->user()->can('posttype_access') ||
                    auth()->user()->can('category_access')||
                    auth()->user()->can('venuefacility_access')||
                    auth()->user()->can('keyfacility_access')||
                    auth()->user()->can('page_access')) {
                    $menu->dropdown('Post', function ($sub) {
                        if(is_module_active('VenueFacility')) {
                            if (auth()->user()->can('venuefacility_access')) {
                                $sub->url(
                                    action('\Modules\VenueFacility\Http\Controllers\VenueFacilityController@index'),
                                    __('venuefacility::lang.venuefacility'),
                                    ['icon' => 'icon-sitemap1']
                                )->order(20);
                            } //next_lint
                            if (auth()->user()->can('keyfacility_access')) {
                                $sub->url(
                                    action('\Modules\VenueFacility\Http\Controllers\KeyFacilityController@index'),
                                    __('venuefacility::lang.keyfacility'),
                                    ['icon' => 'icon-quote-right1']
                                )->order(20);
                            }
                        }
                        if(auth()->user()->can('post_access')) {
                            $sub->url(
                                action('\Modules\Post\Http\Controllers\PostController@index'),
                                __('post::lang.post'),
                                ['icon' => 'icon-line-edit']
                            )->order(20); }
                        if(auth()->user()->can('posttype_access')) {
                            $sub->url(
                                action('\Modules\Post\Http\Controllers\PostTypeController@index'),
                                __('post::lang.posttype'),
                                ['icon' => 'icon-level-up']
                            )->order(20); }
                        if(auth()->user()->can('category_access')) {
                            $sub->url(
                                action('\Modules\Post\Http\Controllers\CategoryController@index'),
                                __('post::lang.category'),
                                ['icon' => 'icon-shield']
                            )->order(20); }
                        if(auth()->user()->can('page_access')) {
                            $sub->url(
                                route('page.index'),
                                __('post::lang.page'),
                                ['icon' => 'icon-hands-helping']
                            )->order(20); }
                        if(auth()->user()->can('pagetemplate_access')) {
                            $sub->url(
                                action('\Modules\Post\Http\Controllers\PageTemplateController@index'),
                                __('post::lang.pagetemplate'),
                                ['icon' => 'icon-sitemap']
                    )->order(20); } //next_lint
                    },
                        ['icon' => 'icon icon-app-store']
                    );
                }

            }
        );
    }

    /**
     * Adds KamrulDashboard menus
     * @return null
     */
    public function modifyAdminDashboard()
    {
        if(auth()->user()->can('category_access')) {
        Dboard::modify('main-dashboard', function($menu) {
            // URL, Title, Attributes
            $data = Category::count();
            $menu->header(__('Total Category'), $data);
        });
    }
        if(auth()->user()->can('post_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Post::count();
                $menu->header(__('Total Post'), $data);
            });
        }
        if(auth()->user()->can('page_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Page::count();
                $menu->header(__('Total Page'), $data);
            });
        }
    }
}



