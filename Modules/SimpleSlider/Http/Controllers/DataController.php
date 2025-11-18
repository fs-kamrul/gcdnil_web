<?php

namespace Modules\SimpleSlider\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\SimpleSlider\Http\Models\SimpleSlider;

class DataController  extends Controller
{

    /**
     * Adds SimpleSlider menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('simple-slider_access')) {
                    $menu->url(
                        action('\Modules\SimpleSlider\Http\Controllers\SimpleSliderController@index'),
                        __('simpleslider::lang.simpleslider'),
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
        if(auth()->user()->can('simple-slider_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = SimpleSlider::get();
                $menu->header('Total SimpleSlider', $data->count());
            });
        }
    }
}
