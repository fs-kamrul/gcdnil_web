<?php

namespace Modules\VenueFacility\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\VenueFacility\Http\Models\VenueFacility;

class DataController  extends Controller
{

    /**
     * Adds VenueFacility menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
//                if(auth()->user()->can('venuefacility_access')) {
//                    $menu->url(
//                        action('\Modules\VenueFacility\Http\Controllers\VenueFacilityController@index'),
//                        __('venuefacility::lang.venuefacility'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); } //next_lint
//                if(auth()->user()->can('keyfacility_access')) {
//                    $menu->url(
//                        action('\Modules\VenueFacility\Http\Controllers\KeyFacilityController@index'),
//                        __('venuefacility::lang.keyfacility'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); }

            }
        );
    }

    /**
     * Adds KamrulDashboard menus
     * @return null
     */
    public function modifyAdminDashboard()
    {
//        if(auth()->user()->can('venuefacility_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = VenueFacility::get();
//                $menu->header('Total VenueFacility', $data->count());
//            });
//        }
    }
}
