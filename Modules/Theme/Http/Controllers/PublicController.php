<?php

namespace Modules\Theme\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Post\Http\Models\Page;
use DboardHelper;
use Modules\Post\Services\PageService;
use Modules\Theme\Events\RenderingHomePageEvent;
use Modules\Theme\Events\RenderingSingleEvent;
use Modules\Theme\Events\RenderingSiteMapEvent;
use SlugHelper;
use SiteMapManager;
use SeoHelper;
use Theme;

class PublicController extends Controller
{

    /**
     * @return \Illuminate\Http\Response|Response
     */
    public function getIndex()
    {
        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            $homepageId = DboardHelper::getHomepageId();
            if ($homepageId) {
                $slug = SlugHelper::getSlug(null, SlugHelper::getPrefix(Page::class), Page::class, $homepageId);

                if ($slug) {
                    $data = (new PageService)->handleFrontRoutes($slug);

                    event(new RenderingSingleEvent($slug));

                    return Theme::scope($data['view'], $data['data'], $data['default_view'])->render();
                }
            }
        }

        SeoHelper::setTitle(theme_option('site_title'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'));

        event(RenderingHomePageEvent::class);

        return Theme::scope('index')->render();
    }
    /**
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse|Response
     * @throws FileNotFoundException
     */
    public function brochure_page($id = null){
        $viewPath = Theme::getThemeNamespace() . '::views';
        Theme::asset()
            ->add('pdfflip', 'vendor/Modules/Theme/pdf_flip/pflip/css/pdfflip.css');

        Theme::asset()
            ->container('footer')
            ->add('jquery', 'vendor/Modules/Theme/pdf_flip/pflip/js/libs/jquery.min.js')
            ->add('pdfflip-js', 'vendor/Modules/Theme/pdf_flip/pflip/js/pdfflip.js')
            ->add('settings-flip-js', 'vendor/Modules/Theme/pdf_flip/settings.js')
            ->add('toc-js', 'vendor/Modules/Theme/pdf_flip/toc.js');
//            ->add('cropper-js', 'vendor/Modules/Ecommerce/libraries/cropper.js', ['jquery']);
//            ->add('avatar-js', 'vendor/Modules/Ecommerce/js/avatar.js', ['jquery']);
        return view(($viewPath ?: 'theme::shortcodes') . '.pdf_flip', ['id' => $id])
            ->render();
//        return Theme::scope('index')->render();
    }
    public function getView($key = null, string $prefix = '')
    {
        if (empty($key)) {
            return $this->getIndex();
        }

        $slug = SlugHelper::getSlug($key, $prefix);

        if (!$slug) {
            abort(404);
        }

        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            if ($slug->reference_type == Page::class && DboardHelper::isHomepage($slug->reference_id)) {
//                return redirect()->route('public.index');
                return redirect()->to(DboardHelper::getHomepageUrl());
            }
        }

        $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);
        $extension = SlugHelper::getPublicSingleEndingURL();

//        dd($result);
        if ($extension) {
            $key = Str::replaceLast($extension, '', $key);
        }
        if ($result instanceof DboardHttpResponse) {
            return $result;
        }

        if (isset($result['slug']) && $result['slug'] !== $key) {
//            return redirect()->route('public.single', $result['slug']);
            $prefix = SlugHelper::getPrefix(get_class(Arr::first($result['data'])));

            return redirect()->route('public.single', empty($prefix) ? $result['slug'] : "$prefix/{$result['slug']}");
        }

        event(new RenderingSingleEvent($slug));

//        if (!empty($result) && is_array($result)) {
//            return Theme::scope($result['view'], $result['data'], Arr::get($result, 'default_view'))->render();
//        }

        if (! empty($result) && is_array($result)) {
            if (isset($result['view'])) {
                Theme::addBodyAttributes(['id' => Str::slug(Str::snake(Str::afterLast($slug->reference_type, '\\'))) . '-' . $slug->reference_id]);

                return Theme::scope($result['view'], $result['data'], Arr::get($result, 'default_view'))->render();
            }

            return $result;
        }

        abort(404);
    }
    /**
     * @return string
     */
//    public function getSiteMap()
//    {
////        return 'ok Done';
//        event(RenderingSiteMapEvent::class);
////        dd(SiteMapManager::render());
//        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
//        return SiteMapManager::render();
//    }
    public function getSiteMap()
    {
        return $this->getSiteMapIndex();
    }

    public function getSiteMapIndex(string $key = null, string $extension = 'xml')
    {
        if ($key == 'sitemap') {
            $key = null;
        }

        if (! SiteMapManager::init($key, $extension)->isCached()) {
            event(new RenderingSiteMapEvent($key));
        }

        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return SiteMapManager::render($key ? $extension : 'sitemapindex');
    }
    public function getViewWithPrefix(string $prefix, ?string $slug = null)
    {
        return $this->getView($slug, $prefix);
    }
}
