<?php

namespace Modules\SeoHelper\Providers;

use Assets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use DboardHelper;
use MetaBox;
use Modules\Post\Http\Models\Page;
use SeoHelper;

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
//add_new_line_Interface_and_Repository_to_hook


        add_action(BASE_ACTION_META_BOXES, [$this, 'addMetaBox'], 12, 2);
        add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, [$this, 'setSeoMeta'], 56, 2);
    }
    public function addMetaBox(string $priority, ?Model $data): void
    {
        if ($priority == 'advanced' && ! empty($data) && in_array(get_class($data), config('seohelper.supported', []))) {
            if (get_class($data) == Page::class && DboardHelper::isHomepage($data->id)) {
                return;
            }

            Assets::addScriptsDirectly('vendor/Modules/SeoHelper/js/seo-helper.js')
                ->addStylesDirectly('vendor/Modules/SeoHelper/css/seo-helper.css');

            MetaBox::addMetaBox(
                'seo_wrap',
                trans('seohelper::lang.meta_box_header'),
                [$this, 'seoMetaBox'],
                get_class($data),
                'advanced',
                'low'
            );
        }
    }
    public function seoMetaBox()
    {
        $meta = [
            'seo_title' => null,
            'seo_description' => null,
        ];

        $args = func_get_args();
        if (! empty($args[0]) && $args[0]->id) {
            $metadata = MetaBox::getMetaData($args[0], 'seo_meta', true);
        }

        if (! empty($metadata) && is_array($metadata)) {
            $meta = array_merge($meta, $metadata);
        }

        $object = $args[0];

        return view('seohelper::meta-box', compact('meta', 'object'));
    }

    public function setSeoMeta(string $screen, ?Model $object): bool
    {
        if (get_class($object) == Page::class && DboardHelper::isHomepage($object->id)) {
            return false;
        }

        $object->loadMissing('metadata');
        $meta = $object->getMetaData('seo_meta', true);

        if (! empty($meta)) {
            if (! empty($meta['seo_title'])) {
                SeoHelper::setTitle($meta['seo_title']);
            }

            if (! empty($meta['seo_description'])) {
                SeoHelper::setDescription($meta['seo_description']);
            }
        }

        return true;
    }
}
