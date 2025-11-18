<?php

namespace Modules\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Menus\Http\Models\Menus;

class DataController  extends Controller
{

    /**
     * Adds Menus menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('menus_access')) {
//                    $menu->url(
//                        action('\Modules\Menus\Http\Controllers\MenusController@index'),
//                        __('menus::lang.menus'),
//                        ['icon' => 'icon-line-menu']
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
        if(auth()->user()->can('menus_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Menus::get();
                $menu->header('Total Menus', $data->count());
            });
        }
    }
}
