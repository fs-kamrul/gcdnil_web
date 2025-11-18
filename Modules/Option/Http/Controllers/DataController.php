<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Option\Http\Models\Option;

class DataController  extends Controller
{

    /**
     * Adds Option menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('option_access') ||
                    auth()->user()->can('optionsection_access') ||
                    auth()->user()->can('optiongroup_access')||
                    auth()->user()->can('optionyear_access')||
                    auth()->user()->can('optionset_access')||
                    auth()->user()->can('optionbloodgroup_access')||
                    auth()->user()->can('optionclass_access')) {
                    $menu->dropdown('Option', function ($sub) {

//                        if(auth()->user()->can('option_access')) {
//                            $sub->url(
//                                action('\Modules\Option\Http\Controllers\OptionController@index'),
//                                __('option::lang.option'),
//                                ['icon' => 'icon-file-signature']
//                            )->order(20); } //next_lint
                        if(auth()->user()->can('optionclass_access')) {
                            $sub->url(
                                action('\Modules\Option\Http\Controllers\OptionClassController@index'),
                                __('option::lang.optionclass'),
                                ['icon' => 'icon-project-diagram']
                            )->order(20); }

                        if(auth()->user()->can('optiongroup_access')) {
                            $sub->url(
                                action('\Modules\Option\Http\Controllers\OptionGroupController@index'),
                                __('option::lang.optiongroup'),
                                ['icon' => 'icon-layer-group']
                            )->order(20); }

                        if(auth()->user()->can('optionyear_access')) {
                            $sub->url(
                                action('\Modules\Option\Http\Controllers\OptionYearController@index'),
                                __('option::lang.optionyear'),
                                ['icon' => 'icon-not-equal']
                            )->order(20); }
                        if(auth()->user()->can('optionsection_access')) {
                            $sub->url(
                                action('\Modules\Option\Http\Controllers\OptionSectionController@index'),
                                __('option::lang.optionsection'),
                                ['icon' => 'icon-grid']
                    )->order(20); } //next_lint
                if(auth()->user()->can('optionbloodgroup_access')) {
                    $sub->url(
                        action('\Modules\Option\Http\Controllers\OptionBloodGroupController@index'),
                        __('option::lang.optionbloodgroup'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('optionset_access')) {
                    $sub->url(
                        action('\Modules\Option\Http\Controllers\OptionSetController@index'),
                        __('option::lang.optionset'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('optionsubject_access')) {
                    $sub->url(
                        action('\Modules\Option\Http\Controllers\OptionSubjectController@index'),
                        __('option::lang.optionsubject'),
                        ['icon' => 'icon-puzzle']
                    )->order(20); }
                if(auth()->user()->can('optiongender_access')) {
                    $sub->url(
                        action('\Modules\Option\Http\Controllers\OptionGenderController@index'),
                        __('option::lang.optiongender'),
                        ['icon' => 'icon-transgender-alt']
                    )->order(20); }
                if(auth()->user()->can('optionreligion_access')) {
                    $sub->url(
                        action('\Modules\Option\Http\Controllers\OptionReligionController@index'),
                        __('option::lang.optionreligion'),
                        ['icon' => 'icon-tag1']
                    )->order(20); }

                    },
                        ['icon' => 'icon-recycle']
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
//        if(auth()->user()->can('option_access')) {
//            Dboard::modify('main-dashboard', function($menu) {
//                // URL, Title, Attributes
//                $data = Option::get();
//                $menu->header('Total Option', $data->count());
//            });
//        }
    }
}








