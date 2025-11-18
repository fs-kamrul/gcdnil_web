<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Faq\Http\Models\Faq;

class DataController  extends Controller
{

    /**
     * Adds Faq menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
//                if(auth()->user()->can('faq_access')) {
//                    $menu->url(
//                        action('\Modules\Faq\Http\Controllers\FaqController@index'),
//                        __('faq::lang.faq'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); } //next_lint
//                if(auth()->user()->can('faqcategory_access')) {
//                    $menu->url(
//                        action('\Modules\Faq\Http\Controllers\FaqCategoryController@index'),
//                        __('faq::lang.faqcategory'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); }

                if(auth()->user()->can('faq_access') || auth()->user()->can('faqcategory_access')) {
                    $menu->dropdown(__('faq::lang.faq'), function ($sub) {
                        if (auth()->user()->can('report_access')) {
                            $sub->url(
                                action('\Modules\Faq\Http\Controllers\FaqController@index'),
                                __('faq::lang.faq'),
                                ['icon' => 'icon-glass-martini-alt']
                            )->order(20);
                        }
                        if(auth()->user()->can('faqcategory_access')) {
                            $sub->url(
                                action('\Modules\Faq\Http\Controllers\FaqCategoryController@index'),
                                __('faq::lang.faqcategory'),
                                ['icon' => 'icon-flag-checkered']
                            )->order(20);
                        }
                    },
                        ['icon' => 'icon-file-medical']
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
        if(auth()->user()->can('faq_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Faq::get();
                $menu->header('Total Faq', $data->count());
            });
        }
    }
}
