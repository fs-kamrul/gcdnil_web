<?php

namespace Modules\Theme\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Savefunction;
use Modules\Theme\Http\Models\Theme;

class DataController  extends Controller
{

    /**
     * Adds Theme menus
     * @return null
     */
    public function modifyAdminMenu()
    {
//appearance
        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('theme_access') || auth()->user()->can('widget_access') || auth()->user()->can('menus_access')) {
                    $menu->dropdown(__('Appearance'), function ($sub) {
                        if(auth()->user()->can('theme_access')) {
                            $sub->url(
                                action('\Modules\Theme\Http\Controllers\ThemeController@index'),
                                __('theme::lang.theme'),
                                ['icon' => 'icon-feather-alt']
                            )->order(20);
                            $sub->url(
                                action('\Modules\Theme\Http\Controllers\ThemeController@getOptions'),
                                __('theme::lang.theme_setting'),
                                ['icon' => 'icon-file-archive']
                            )->order(20);
                            if(auth()->user()->can('language_access') && Savefunction::request_module_defined('Language')) {
                                $sub->url(
                                    action('\Modules\Language\Http\Controllers\LanguageController@index'),
                                    __('language::lang.language'),
                                    ['icon' => 'icon-language']
                                )->order(20);
                            }
                        }
                        if(auth()->user()->can('widget_access') && Savefunction::request_module_defined('Widget')) {
                            $sub->url(
                                action('\Modules\Widget\Http\Controllers\WidgetController@index'),
                                __('widget::lang.widget'),
                                ['icon' => 'icon-theater-masks']

                            )->order(20); }
                        if(auth()->user()->can('menus_access')) {
                            $sub->url(
                                action('\Modules\Menus\Http\Controllers\MenusController@index'),
                                __('menus::lang.menus'),
                                ['icon' => 'icon-line-menu']
                            )->order(20); }
                    },
                        ['icon' => 'icon-th-large']
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
//        if(auth()->user()->can('theme_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = Theme::get();
//                $menu->header('Total Theme', $data->count());
//            });
//        }
    }
}
