<?php

namespace Modules\Shortcodes\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Shortcodes\Http\Models\Shortcodes;

class DataController  extends Controller
{

    /**
     * Adds Shortcodes menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('shortcodes_access')) {
//                    $menu->url(
//                        action('\Modules\Shortcodes\Http\Controllers\ShortcodesController@index'),
//                        __('shortcodes::lang.shortcodes'),
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
//        if(auth()->user()->can('shortcodes_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = Shortcodes::get();
//                $menu->header('Total Shortcodes', $data->count());
//            });
//        }
    }
}
