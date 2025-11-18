<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Location\Http\Models\Country;

class DataController  extends Controller
{

    /**
     * Adds Location menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if (auth()->user()->can('city_access') ||
                    auth()->user()->can('country_access') ||
                    auth()->user()->can('state_access')) {
                    $menu->dropdown(__('location::lang.location'), function ($sub) {
                        if(auth()->user()->can('country_access')) {
                            $sub->url(
                                action('\Modules\Location\Http\Controllers\CountryController@index'),
                                __('location::lang.country'),
                                ['icon' => 'icon-line-location-2']
                            )->order(20);
                        }
                        if(auth()->user()->can('state_access')) {
                            $sub->url(
                                action('\Modules\Location\Http\Controllers\StateController@index'),
                                __('location::lang.state'),
                                ['icon' => 'icon-location-arrow']
                            )->order(20);
                        }
                        if(auth()->user()->can('city_access')) {
                            $sub->url(
                                action('\Modules\Location\Http\Controllers\CityController@index'),
                                __('location::lang.city'),
                                ['icon' => 'icon-search-location']
                            )->order(20);
                        }
                    },
                        ['icon' => 'icon-location']
                    );
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
        if(auth()->user()->can('location_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Country::get();
                $menu->header('Total Country', $data->count());
            });
        }
    }
}


