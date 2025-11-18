<?php

namespace Modules\ContactForm\Providers;

use Assets;
use Html;
use Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Modules\ContactForm\Enums\ContactStatus;
use Modules\ContactForm\Repositories\Interfaces\ContactInterface;
use Modules\Shortcodes\Compilers\Shortcode;
use Theme;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_TOP_HEADER_LAYOUT, [$this, 'registerTopHeaderNotification'], 120);
        add_filter(BASE_FILTER_APPEND_MENU_NAME, [$this, 'getUnreadCount'], 120, 2);
        add_filter(BASE_FILTER_MENU_ITEMS_COUNT, [$this, 'getMenuItemCount'], 120);

        if (function_exists('add_shortcode')) {
            add_shortcode(
                'contact-form',
                trans('contactform::contact.shortcode_name'),
                trans('contactform::contact.shortcode_description'),
                [$this, 'form']
            );

            shortcode()
                ->setAdminConfig('contact-form', function ($attributes) {
                    return view('contactform::partials.short-code-admin-config', compact('attributes'))->render();
//                return Theme::partial('short-codes.category-with-courses-admin-config', compact('attributes'));
            });//, view('contactform::partials.short-code-admin-config')->render());
        }

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 93);

        Form::component('information', 'contactform::contact-info', [
            'title' => trans('contactform::contact.contact_information'),
            'contact' => null,
            'attributes' => [
                'style' => 'margin-top: 0',
            ],
        ]);
        Form::component('replies', 'contactform::reply-box', [
            'title' => trans('contactform::contact.replies'),
            'contact' => null,
        ]);
    }

    public function registerTopHeaderNotification(?string $options): ?string
    {
        if (Auth::user()->can('contactform_edit')) {
            $contacts = $this->app[ContactInterface::class]
                ->advancedGet([
                    'condition' => [
                        'status' => ContactStatus::UNREAD,
                    ],
                    'paginate' => [
                        'per_page' => 10,
                        'current_paged' => 1,
                    ],
                    'select' => ['id', 'name', 'email', 'phone', 'created_at'],
                    'order_by' => ['created_at' => 'DESC'],
                ]);

            if ($contacts->count() == 0) {
                return $options;
            }

            return $options . view('plugins/contact::partials.notification', compact('contacts'))->render();
        }

        return $options;
    }

    public function getUnreadCount($number, string $menuId)
    {
        if ($menuId !== 'cms-plugins-contact') {
            return $number;
        }

        $attributes = [
            'class' => 'badge badge-success menu-item-count unread-contacts',
            'style' => 'display: none;',
        ];

        return Html::tag('span', '', $attributes)->toHtml();
    }

    public function getMenuItemCount(array $data = []): array
    {
        if (Auth::user()->can('contactform.index')) {
            $data[] = [
                'key' => 'unread-contacts',
                'value' => app(ContactInterface::class)->countUnread(),
            ];
        }

        return $data;
    }

    public function form(Shortcode $shortcode): string
    {
        $view = apply_filters(CONTACT_FORM_TEMPLATE_VIEW, 'contactform::forms.contact');

        if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $this->app->booted(function () {
                Theme::asset()
                    ->usePath(false)
                    ->add('contact-css', asset('vendor/Modules/ContactForm/css/contact-public.css'), [], [], '1.0.0');

                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add(
                        'contact-public-js',
                        asset('vendor/Modules/ContactForm/js/contact-public.js'),
                        ['jquery'],
                        [],
                        '1.0.0'
                    );
            });
        }

        if ($shortcode->view && view()->exists($shortcode->view)) {
            $view = $shortcode->view;
        }

        return view($view, compact('shortcode'))->render();
    }

    public function addSettings(?string $data = null): string
    {
        Assets::addStylesDirectly('vendor/Modules/KamrulDashboard/vendor2/tagify/tagify.css')
            ->addScriptsDirectly([
                'vendor/Modules/KamrulDashboard/vendor2/tagify/tagify.js',
                'vendor/Modules/KamrulDashboard/vendor2/js/tags.js',
            ]);

        return $data . view('contactform::settings')->render();
    }
}
