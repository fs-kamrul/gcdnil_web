<?php

namespace Modules\Faq\Providers;

use Assets;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Faq\Http\Models\Faq;
use Modules\Faq\Repositories\Cache\FaqCacheDecorator;
use Modules\Faq\Repositories\Eloquent\FaqRepository;
use Modules\Faq\Repositories\Interfaces\FaqInterface;
//add_new_line_Interface_and_Repository_call
use Modules\Faq\Http\Models\FaqCategory;
use Modules\Faq\Repositories\Eloquent\FaqCategoryRepository;
use Modules\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Modules\Faq\Repositories\Cache\FaqCategoryCacheDecorator;
use DboardHelper;
use MetaBox;
use Html;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(FaqInterface::class, function () {
            return new FaqCacheDecorator(
                new FaqRepository(new Faq)
            );
        });
//add_new_line_Interface_and_Repository_to_hook
        $this->app->bind(FaqCategoryInterface::class, function () {
            return new FaqCategoryCacheDecorator(
                new FaqCategoryRepository(new FaqCategory)
            );
        });

        add_action(BASE_ACTION_META_BOXES, function ($context, $object): void {
            if (! $object || $context != 'advanced') {
                return;
            }

            if (! in_array(get_class($object), config('faq.schema_supported', []))) {
                return;
            }

            if (! setting('enable_faq_schema', 0)) {
                return;
            }

            Assets::addStylesDirectly(['vendor/Modules/Faq/css/faq.css'])
                ->addScriptsDirectly(['vendor/Modules/Faq/js/faq.js']);

            MetaBox::addMetaBox(
                'faq_schema_config_wrapper',
                trans('faq::faq.faq_schema_config', [
                    'link' => Html::link(
                        'https://developers.google.com/search/docs/data-types/faqpage',
                        trans('faq::faq.learn_more'),
                        ['target' => '_blank']
                    ),
                ]),
                function () {
                    $value = [];

                    $args = func_get_args();
                    if ($args[0] && $args[0]->id) {
                        $value = MetaBox::getMetaData($args[0], 'faq_schema_config', true);
                    }

                    $hasValue = ! empty($value);

                    $value = json_encode((array)$value);

                    return view('faq::schema-config-box', compact('value', 'hasValue'))->render();
                },
                get_class($object),
                $context
            );
        }, 39, 2);

        add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, function ($screen, $object): void {
            add_filter(THEME_FRONT_HEADER, function ($html) use ($object): ?string {
                if (! in_array(get_class($object), config('plugins.faq.general.schema_supported', []))) {
                    return $html;
                }

                if (! setting('enable_faq_schema', 0)) {
                    return $html;
                }

                $value = MetaBox::getMetaData($object, 'faq_schema_config', true);

                if (! $value || ! is_array($value)) {
                    return $html;
                }

                if (! empty($value)) {
                    foreach ($value as $key => $item) {
                        if (! $item[0]['value'] && ! $item[1]['value']) {
                            Arr::forget($value, $key);
                        }
                    }
                }

                $schema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => [],
                ];

                foreach ($value as $item) {
                    $schema['mainEntity'][] = [
                        '@type' => 'Question',
                        'name' => DboardHelper::clean($item[0]['value']),
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => DboardHelper::clean($item[1]['value']),
                        ],
                    ];
                }

                $schema = json_encode($schema);

                return $html . Html::tag('script', $schema, ['type' => 'application/ld+json'])->toHtml();
            }, 39);
        }, 39, 2);

//        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 59);
    }

//    public function addSettings(?string $data = null): string
//    {
//        return $data . view('faq::settings')->render();
//    }
}

