<?php

namespace Modules\SocialLogin\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\SocialLogin\Http\Models\SocialLogin;

class DataController  extends Controller
{

    /**
     * Adds SocialLogin menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('sociallogin_access')) {
//                    $menu->url(
//                        route('social-login.settings'),
//                        __('sociallogin::lang.sociallogin'),
//                        ['icon' => 'icon-line2-social-dribbble']
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
//        if(auth()->user()->can('sociallogin_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = SocialLogin::get();
//                $menu->header('Total SocialLogin', $data->count());
//            });
//        }
    }
}
