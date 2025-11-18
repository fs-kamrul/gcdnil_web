<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\KamrulDashboard\Http\Models\KamrulDashboard;

class DataController  extends Controller
{

    /**
     * Adds KamrulDashboard menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('kamruldashboard_access')) {
                    $menu->url(
                        action('\Modules\KamrulDashboard\Http\Controllers\KamrulDashboardController@index'),
                        __('kamruldashboard::lang.kamruldashboard'),
                        ['icon' => 'icon-tape']
                    )->order(20); } //next_lint
                if(auth()->user()->can('user_access') || auth()->user()->can('role_access') || auth()->user()->can('permission_access')) {
                    $menu->dropdown('User Management', function ($sub) {
                        if (auth()->user()->can('user_access')) {
                            $sub->url(
                                action('\Modules\KamrulDashboard\Http\Controllers\UserController@index'),
                                __('kamruldashboard::lang.user'),
                                ['icon' => 'icon-line2-users']
                            );
                        }
                        if (auth()->user()->can('role_access')) {
                            $sub->url(
                                action('\Modules\KamrulDashboard\Http\Controllers\RoleController@index'),
                                __('kamruldashboard::lang.role'),
                                ['icon' => 'icon-archive1']
                            );
                        }
                        if (auth()->user()->can('permission_access')) {
                            $sub->url(
                                action('\Modules\KamrulDashboard\Http\Controllers\PermissionController@index'),
                                __('kamruldashboard::lang.permission'),
                                ['icon' => 'icon-unlocked2']
                            );
                        }
//                    $sub->url('settings/password', 'Password', ['icon' => 'icon icon-single-04','target' => '']);
                    },
                        ['icon' => 'icon-users-cog']
                    );
                }
                if(auth()->user()->can('settings_access') || auth()->user()->can('settings.email') || auth()->user()->can('sociallogin_access')) {
                    $menu->dropdown('Settings', function ($sub) {
                        if (auth()->user()->can('settings_access')) {
                            $sub->url(
                                action('\Modules\KamrulDashboard\Http\Controllers\SettingDataController@getOptions'),
                                __('kamruldashboard::setting.general.title'),
                                ['icon' => 'icon-crop1']
                            );
                        }
                        if (auth()->user()->can('settings.email')) {
                            $sub->url(
                                route('settings.email'),
                                __('kamruldashboard::setting.email.name'),
                                ['icon' => 'icon-email2']
                            );
                        }
                        if(auth()->user()->can('sociallogin_access')) {
                            $sub->url(
                                route('social-login.settings'),
                                __('sociallogin::lang.sociallogin'),
                                ['icon' => 'icon-line2-social-dribbble']
                            )->order(20); }
                        },
                        ['icon' => 'icon-settings']
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
//        Dboard::modify('main-dashboard', function($menu) {
//            // URL, Title, Attributes
//            $data = KamrulDashboard::get();
//            $menu->header('Total KamrulDashboard', $data->count());
//        });
    }
}


