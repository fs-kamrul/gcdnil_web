<?php

namespace Modules\Captcha\Providers;

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

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 299);

        add_filter(THEME_FRONT_HEADER, [$this, 'addHeaderMeta'], 299);

        add_filter('cms_settings_validation_rules', [$this, 'addSettingRules'], 299);
//add_new_line_Interface_and_Repository_to_hook
    }
    public function addSettings(?string $data = null): string
    {
        return $data . view('captcha::setting')->render();
    }

    public function addHeaderMeta(?string $html): string
    {
        return $html . view('captcha::header-meta')->render();
    }

    public function addSettingRules(array $rules): array
    {
        return array_merge($rules, [
            'enable_captcha' => 'nullable|in:0,1',
            'captcha_type' => 'nullable|in:v2,v3|required_if:enable_captcha,1',
            'captcha_hide_badge' => 'nullable|in:0,1|required_if:enable_captcha,1',
            'captcha_site_key' => 'nullable|string|required_if:enable_captcha,1',
            'captcha_secret' => 'nullable|string|required_if:enable_captcha,1',
        ]);
    }
}
