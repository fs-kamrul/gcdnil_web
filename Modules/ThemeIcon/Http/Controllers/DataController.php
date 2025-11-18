<?php

namespace Modules\ThemeIcon\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\ThemeIcon\Http\Models\ThemeIcon;

class DataController  extends Controller
{

    /**
     * Adds ThemeIcon menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('themeicon_access')) {
                    $menu->url(
                        action('\Modules\ThemeIcon\Http\Controllers\ThemeIconController@index'),
                        __('themeicon::lang.themeicon'),
                        ['icon' => 'icon-file-code']
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
        if(auth()->user()->can('themeicon_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = ThemeIcon::get();
                $menu->header('Total ThemeIcon', $data->count());
            });
        }
    }
}
