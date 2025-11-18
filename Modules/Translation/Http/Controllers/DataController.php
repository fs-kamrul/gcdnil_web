<?php

namespace Modules\Translation\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\Translation\Http\Models\Translation;

class DataController  extends Controller
{

    /**
     * Adds Translation menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            'admin-sidebar-menu',
            function ($menu){
                if(auth()->user()->can('translation_access')) {
//                    $menu->url(
//                        action('\Modules\Translation\Http\Controllers\TranslationController@getIndex'),
//                        __('translation::lang.translation'),
//                        ['icon' => 'icon-file-signature']
//                    )->order(20); } //next_lint
                    if (auth()->user()->can('translation_access') || auth()->user()->can('translation_locales_access')) {
                        $menu->dropdown(__('Translations'), function ($sub) {
//                            if (auth()->user()->can('translation_access')) {
//                                $sub->url(
//                                    route('translations.index'),
//                                    __('translation::lang.translations'),
//                                    ['icon' => 'icon-feather-alt']
//                                )->order(20);
//                            }
                            if (auth()->user()->can('translation_locales_access')) {
                                $sub->url(
                                    route('translations.locales'),
                                    __('translation::lang.locales'),
                                    ['icon' => 'icon-line-location-2']
                                )->order(20);
                            }
                            if (auth()->user()->can('translation_theme_translations')) {
                                $sub->url(
                                    route('translations.theme-translations'),
                                    __('translation::lang.theme-translations'),
                                    ['icon' => 'icon-sort-by-alphabet']
                                )->order(20);
                            }
                            if (auth()->user()->can('translation_admin_translations')) {
                                $sub->url(
                                    route('translations.index'),
                                    __('translation::lang.admin-translations'),
                                    ['icon' => 'icon-sort-by-attributes']
                                )->order(20);
                            }
                        },
                            ['icon' => 'icon-language']
                        );
                    }
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
        if(auth()->user()->can('translation_access')) {
            Dboard::modify('main-dashboard', function($menu) {
                // URL, Title, Attributes
                $data = Translation::get();
                $menu->header('Total Translation', $data->count());
            });
        }
    }
}
