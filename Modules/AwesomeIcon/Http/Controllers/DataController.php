<?php

namespace Modules\AwesomeIcon\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\AwesomeIcon\Http\Models\AwesomeIcon;

class DataController  extends Controller
{

    /**
     * Adds AwesomeIcon menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('awesomeicon_access')) {
                    $menu->url(
                        action('\Modules\AwesomeIcon\Http\Controllers\AwesomeIconController@index'),
                        __('awesomeicon::lang.awesomeicon'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); } //next_lint
            }
        );
    }

    /**
     * Adds KamrulDashboard menus
     * @return null
     */
    public function modifyAdminDashboard()
    {
        if(auth()->user()->can('awesomeicon_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = AwesomeIcon::get();
                $menu->header('Total AwesomeIcon', $data->count());
            });
        }
    }
}