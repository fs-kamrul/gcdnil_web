<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\AdminBoard\Http\Models\AdminBoard;

class DataController  extends Controller
{

    /**
     * Adds AdminBoard menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('adminboard_access') ||
                    auth()->user()->can('adminstudentguideline_access') ||
                    auth()->user()->can('admincategory_access') ||
                    auth()->user()->can('adminevent_access') ||
                    auth()->user()->can('adminnews_access') ||
                    auth()->user()->can('admingalleryboard_access') ||
                    auth()->user()->can('adminteam_access') ||
                    auth()->user()->can('adminfacility_access') ||
                    auth()->user()->can('admincareernavigator_access') ||
                    auth()->user()->can('admintestimonial_access') ||
                    auth()->user()->can('adminpartner_access') ||
                    auth()->user()->can('adminacademicgroup_access') ||
                    auth()->user()->can('adminworkshop_access')) {
                    $menu->dropdown(__('adminboard::lang.adminboard'), function ($sub) {
//                        if(auth()->user()->can('adminboard_access')) {
//                            $sub->url(
//                                action('\Modules\AdminBoard\Http\Controllers\AdminBoardController@index'),
//                                __('adminboard::lang.adminboard'),
//                                ['icon' => 'icon-file-signature']
//                            )->order(20); }
                        if(auth()->user()->can('admincategory_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminCategoryController@index'),
                                __('adminboard::lang.admincategory'),
                                ['icon' => 'icon-file-signature']
                            )->order(20); }
                        if(auth()->user()->can('adminworkshop_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminWorkshopController@index'),
                                __('adminboard::lang.adminworkshop'),
                                ['icon' => 'icon-file-signature']
                            )->order(20); }
                        if(auth()->user()->can('adminevent_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminEventController@index'),
                                __('adminboard::lang.adminevent'),
                                ['icon' => 'icon-file-signature']
                            )->order(20); }
                        if(auth()->user()->can('adminnews_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminNewsController@index'),
                                __('adminboard::lang.adminnews'),
                                ['icon' => 'icon-file-signature']
                    )->order(20); } //next_lint
                if(auth()->user()->can('adminclub_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminClubController@index'),
                        __('adminboard::lang.adminclub'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('admingalleryboard_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminGalleryBoardController@index'),
                        __('adminboard::lang.admingalleryboard'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('adminstudentguideline_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminStudentGuidelineController@index'),
                        __('adminboard::lang.adminstudentguideline'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('adminacademicgroup_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminAcademicGroupController@index'),
                        __('adminboard::lang.adminacademicgroup'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('admineducation_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminEducationController@index'),
                        __('adminboard::lang.admineducation'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }

                if(auth()->user()->can('adminnoticeboard_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminNoticeBoardController@index'),
                        __('adminboard::lang.adminnoticeboard'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }


                if(auth()->user()->can('adminteam_access')) {
                    $sub->url(
                        action('\Modules\AdminBoard\Http\Controllers\AdminTeamController@index'),
                        __('adminboard::lang.adminteam'),
                        ['icon' => 'icon-file-signature']
                    )->order(20); }
                        if(auth()->user()->can('adminfacility_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminFacilityController@index'),
                                __('adminboard::lang.adminfacility'),
                                ['icon' => 'icon-file-signature']
                            )->order(20); }

                        if(auth()->user()->can('admincareernavigator_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminCareerNavigatorController@index'),
                                __('adminboard::lang.admincareernavigator'),
                                ['icon' => 'icon-file-signature']
                            )->order(20); }
                        if(auth()->user()->can('admintestimonial_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminTestimonialController@index'),
                                __('adminboard::lang.admintestimonial'),
                                ['icon' => 'icon-file-signature']
                            )->order(20); }
                        if(auth()->user()->can('adminpartner_access')) {
                            $sub->url(
                                action('\Modules\AdminBoard\Http\Controllers\AdminPartnerController@index'),
                                __('adminboard::lang.adminpartner'),
                                ['icon' => 'icon-file-signature']
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
        if(auth()->user()->can('adminboard_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = AdminBoard::get();
                $menu->header('Total AdminBoard', $data->count());
            });
        }
    }
}














