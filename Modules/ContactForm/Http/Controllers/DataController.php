<?php

namespace Modules\ContactForm\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\ContactForm\Http\Models\ContactForm;

class DataController  extends Controller
{

    /**
     * Adds ContactForm menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('contactform_access')) {
                    $menu->url(
                        action('\Modules\ContactForm\Http\Controllers\ContactFormController@index'),
                        __('contactform::lang.contactform'),
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
        if(auth()->user()->can('contactform_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = ContactForm::get();
                $menu->header('Total ContactForm', $data->count());
            });
        }
    }
}
