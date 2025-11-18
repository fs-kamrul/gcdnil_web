<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Admission\Http\Models\Admission;

class DataController  extends Controller
{

    /**
     * Adds Admission menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('option_access') ||
                    auth()->user()->can('admissionmerit_access') ||
                    auth()->user()->can('admissionsubject_access')||
                    auth()->user()->can('admission_access')||
                    auth()->user()->can('optionclass_access')) {
                    $menu->dropdown('Admission', function ($sub) {

                        if(auth()->user()->can('optionclass_access')) {
                            $sub->url(
                                action('\Modules\Admission\Http\Controllers\AdmissionClassController@index'),
                                __('option::lang.optionclass'),
                                ['icon' => 'icon-project-diagram']
                            )->order(20); }

                        if(auth()->user()->can('admission_access')) {
                            $sub->url(
                                action('\Modules\Admission\Http\Controllers\AdmissionController@index'),
                                __('admission::lang.admission_list'),
                                ['icon' => 'icon-folder-add']
                    )->order(20); } //next_lint

//                if(auth()->user()->can('admissionmark_access')) {
//                    $sub->url(
//                        action('\Modules\Admission\Http\Controllers\AdmissionMarkController@index'),
//                        __('admission::lang.admissionmark'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); }

                        if(auth()->user()->can('admissionsubject_access')) {
                            $sub->url(
                                action('\Modules\Admission\Http\Controllers\AdmissionSubjectController@index'),
                                __('admission::lang.admissionsubject'),
                                ['icon' => 'icon-atlas']
                            )->order(20); }
                        if(auth()->user()->can('admissionmerit_access')) {
                            $sub->url(
                                action('\Modules\Admission\Http\Controllers\AdmissionMeritController@index'),
                                __('admission::lang.admissionmerit'),
                                ['icon' => 'icon-allergies']
                            )->order(20); }

                    },
                        ['icon' => 'icon-theater-masks']
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
        if(auth()->user()->can('admission_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Admission::get();
                $menu->header('Total Admission', $data->count());
            });
        }
    }
}



