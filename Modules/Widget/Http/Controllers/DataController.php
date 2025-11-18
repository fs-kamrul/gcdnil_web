<?php

namespace Modules\Widget\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Widget\Http\Models\Widget;

class DataController  extends Controller
{

    /**
     * Adds Widget menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('widget_access')) {
//                    $menu->url(
//                        action('\Modules\Widget\Http\Controllers\WidgetController@index'),
//                        __('widget::lang.widget'),
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
        if(auth()->user()->can('widget_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Widget::get();
                $menu->header('Total Widget', $data->count());
            });
        }
    }
}
