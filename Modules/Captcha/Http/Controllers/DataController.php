<?php

namespace Modules\Captcha\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Captcha\Http\Models\Captcha;

class DataController  extends Controller
{

    /**
     * Adds Captcha menus
     * @return null
     */
    public function modifyAdminMenu()
    {

//        Menu::modify(
//            'admin-sidebar-menu',
//            function ($menu){
//                if(auth()->user()->can('captcha_access')) {
//                    $menu->url(
//                        action('\Modules\Captcha\Http\Controllers\CaptchaController@index'),
//                        __('captcha::lang.captcha'),
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
//        if(auth()->user()->can('captcha_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = Captcha::get();
//                $menu->header('Total Captcha', $data->count());
//            });
//        }
    }
}
