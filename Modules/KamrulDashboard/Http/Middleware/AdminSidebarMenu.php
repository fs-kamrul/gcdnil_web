<?php

namespace Modules\KamrulDashboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Menu;
use Dboard;
use Modules\KamrulDashboard\Utils\PluginUtil;


class AdminSidebarMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }
        Menu::create('admin-sidebar-menu', function($menu) {
            // URL, Title, Attributes
            $menu->header('Main Menu');
            $menu->url(
                route('dashboard.index'),
                __('kamruldashboard::all_lang.dashboard'),
                ['icon' => 'icon icon-home','target' => '']
            );
            if(auth()->user()->can('manage_plugins')) {
                $menu->url(
                    route('plugins.index'),
                    __('kamruldashboard::all_lang.plugins'),
                    ['icon' => 'icon icon-plug', 'target' => '']
                );
            }
            if(auth()->user()->can('settings_access')) {
                $menu->url(
                    'systemsettings/settings',
                    __('kamruldashboard::all_lang.settings'),
                    ['icon' => 'icon icon-settings', 'target' => '']
                );
            }
            //Backup menu
            if (auth()->user()->can('backup')) {
                $menu->url(
                    route('kamruldashboard.backup'),
                    __('kamruldashboard::lang.backup'),
                    ['icon' => 'icon-file-signature']
                );
            }
            if(auth()->user()->can('systems_access')) {
                $menu->url(
                    route('system.cache'),
                    __('kamruldashboard::lang.cache_management'),
                    ['icon' => 'icon-file-signature', 'target' => '']
                );
            }
//            $menu->dropdown('Test', function ($sub) {
//                    $sub->url(
//                        'settings/account',
//                        'Account',
//                        ['icon' => 'icon icon-single-04','target' => '']
//                    );
//                    $sub->url('settings/password', 'Password', ['icon' => 'icon icon-single-04','target' => '']);
//                    $sub->url('settings/design', 'Design');
//                },
//                ['icon' => 'icon icon-analytics']
//            );
            $menu->header('Admin Tasks');
        });
        $moduleUtil = new PluginUtil;
        $moduleUtil->getModuleData('modifyAdminMenu');
        return $next($request);
    }
}
