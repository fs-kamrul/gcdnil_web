<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Newsletter\Http\Models\Newsletter;

class DataController  extends Controller
{

    /**
     * Adds Newsletter menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('newsletter_access')) {
                    $menu->url(
                        action('\Modules\Newsletter\Http\Controllers\NewsletterController@index'),
                        __('newsletter::lang.newsletter'),
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
        if(auth()->user()->can('newsletter_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Newsletter::get();
                $menu->header('Total Newsletter', $data->count());
            });
        }
    }
}
