<?php

namespace Modules\Language\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Language\Http\Models\Language;

class DataController  extends Controller
{

    /**
     * Adds Language menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('language_access')) {
//                    $menu->url(
//                        action('\Modules\Language\Http\Controllers\LanguageController@index'),
//                        __('language::lang.language'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); } //next_lint
//            }
//        );
    }

    /**
     * Adds KamrulDashboard menus
     * @return null
     */
    public function modifyAdminDashboard()
    {
        if(auth()->user()->can('language_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Language::get();
                $menu->header('Total Language', $data->count());
            });
        }
    }
}
