<?php

namespace Modules\Newsletter\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Newsletter\Http\Models\Newsletter;
use Modules\Newsletter\Repositories\Eloquent\NewsletterRepository;
use Modules\Newsletter\Repositories\Interfaces\NewsletterInterface;
use Theme;
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
        $this->app->bind(NewsletterInterface::class, function () {
            return new NewsletterRepository(new Newsletter);
        });
        $this->add_shortcode();
//add_new_line_Interface_and_Repository_to_hook
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function add_shortcode()
    {
        if (function_exists('add_shortcode')) {
            add_shortcode('newsletter', trans('newsletter::lang.newsletter'), trans('newsletter::lang.add_newsletter'), [$this, 'newsletter']);
//            view(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
//            dd(Theme::getThemeNamespace());
            shortcode()
                ->setAdminConfig('newsletter', view('newsletter::partials.newsletter-admin-config')->render());
        }
    }
    /**
     * @return string
     * @throws \Throwable
     */
    public function newsletter($shortcode)
    {
        $view = apply_filters(NEWSLETTER_MODULE_SCREEN_NAME, 'newsletter::forms.contact');

        if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $this->app->booted(function () {
                Theme::asset()
                    ->usePath(false)
                    ->add('contact-css', url('vendor/Modules/ContactForm/css/contact-public.css'), [], [], '1.0.0');

                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('contact-public-js', url('vendor/Modules/ContactForm/js/contact-public.js'),
                        ['jquery'], [], '1.0.0');
            });
        }

        if ($shortcode->view && view()->exists($shortcode->view)) {
            $view = $shortcode->view;
        }

        return view($view)->render();
    }
}
