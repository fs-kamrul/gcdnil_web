<?php

namespace Modules\Table\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Table\Http\Models\Table;

class DataController  extends Controller
{

    /**
     * Adds Table menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('table_access')) {
//                    $menu->url(
//                        action('\Modules\Table\Http\Controllers\TableController@index'),
//                        __('table::lang.table'),
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
//        if(auth()->user()->can('table_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = Table::get();
//                $menu->header('Total Table', $data->count());
//            });
//        }
    }
}
