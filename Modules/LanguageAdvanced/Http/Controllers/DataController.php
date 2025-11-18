<?php

namespace Modules\LanguageAdvanced\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\LanguageAdvanced\Http\Models\LanguageAdvanced;

class DataController  extends Controller
{

    /**
     * Adds LanguageAdvanced menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('languageadvanced_access')) {
//                    $menu->url(
//                        action('\Modules\LanguageAdvanced\Http\Controllers\LanguageAdvancedController@index'),
//                        __('languageadvanced::lang.languageadvanced'),
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
    }
}
