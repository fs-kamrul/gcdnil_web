<?php

namespace Modules\SocialLogin\Providers;


use Illuminate\Support\Arr;
use SocialService;
use Theme;
use Illuminate\Support\ServiceProvider;
//add_new_line_Interface_and_Repository_call

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (SocialService::setting('enable')) {
            add_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, [$this, 'addLoginOptions'], 25, 2);
        }
//add_new_line_Interface_and_Repository_to_hook
    }

    public function addLoginOptions(?string $html, string $module): ?string
    {
        if (! SocialService::isSupportedModule($module)) {
            return $html;
        }

        if ($total = count(SocialService::supportedModules())) {
            $params = [];
            $data = collect(SocialService::supportedModules())->firstWhere('model', $module);

            if ($total > 1) {
                $params = ['guard' => $data['guard']];
            }

            if (Arr::get($data, 'use_css', true) && defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
                Theme::asset()
                    ->usePath(false)
                    ->add(
                        'social-login-css',
                        asset('vendor/Modules/SocialLogin/css/social-login.css'),
                        [],
                        [],
                        '1.1.0'
                    );
            }

            $view = Arr::get($data, 'view', 'sociallogin::login-options');

            return $html . view($view, compact('params'))->render();
        }

        return $html;
    }
}
