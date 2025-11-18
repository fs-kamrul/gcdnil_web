<?php

namespace Modules\Analytics\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Analytics\Http\Models\Analytics;

class DataController  extends Controller
{

    /**
     * Adds Analytics menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('analytics_access')) {
//                    $menu->url(
//                        action('\Modules\Analytics\Http\Controllers\AnalyticsController@index'),
//                        __('analytics::lang.analytics'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); } //next_lint
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
//        if(auth()->user()->can('analytics_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = Analytics::get();
//                $menu->header('Total Analytics', $data->count());
//            });
//        }
    }
}
