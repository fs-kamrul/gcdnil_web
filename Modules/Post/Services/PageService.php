<?php

namespace Modules\Post\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Http\Models\Page;
use Modules\Post\Repositories\Interfaces\PageInterface;
use Modules\SeoHelper\Packages\Supports\SeoOpenGraph;
use Theme;
use DboardHelper;
use SeoHelper;

class PageService
{
    /**
     * @param Model $slug
     * @return array|Model
     */
    public function handleFrontRoutes($slug)
    {
//        dd($slug);
//        return !$slug instanceof Model;
        if (!$slug instanceof Model) {
            return $slug;
        }

        $condition = [
            'id'     => $slug->reference_id,
            'status' => DboardStatus::PUBLISHED,
        ];
        if (Auth::check() && request()->input('preview')) {
            Arr::forget($condition, 'status');
        }

        if ($slug->reference_type !== Page::class) {
            return $slug;
        }

        $page = app(PageInterface::class)->getFirstBy($condition, ['*'], ['slugable']);

//        dd($page->url);
        if (empty($page)) {
            abort(404);
        }

        $meta = new SeoOpenGraph;
        if ($page->photo) {
            $meta->setImage($meta->setImage(getImageUrl($page->photo, 'page')));
        }

        if (!DboardHelper::isHomepage($page->id)) {
            SeoHelper::setTitle($page->name)
                ->setDescription($page->short_description);

            $meta->setTitle($page->name);
            $meta->setDescription($page->short_description);
        } else {
            $siteTitle = theme_option('seo_title') ? theme_option('seo_title') : theme_option('site_title');
            $seoDescription = theme_option('seo_description');

            SeoHelper::setTitle($siteTitle)
                ->setDescription($seoDescription);

            $meta->setTitle($siteTitle);
            $meta->setDescription($seoDescription);
        }
//
        $meta->setUrl($page->url);
//        $meta->setType('article');
//
        SeoHelper::setSeoOpenGraph($meta);

//        dd($page->page_templates->slug);
        if ($page->page_templates->slug) {
            Theme::uses(Theme::getThemeName())
                ->layout($page->page_templates->slug);
        }
        if (function_exists('admin_bar') && Auth::check() && auth()->user()->can('page_edit')) {
            admin_bar()
                ->registerLink(trans('post::lang.edit_this_page'), url('post/page/' . $page->id . "/edit"));//route('post.page.edit', $page->id));
        }

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PAGE_MODULE_SCREEN_NAME, $page);
        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(SeoHelper::getTitle(), $page->url);

        return [
            'view'         => 'page',
            'default_view' => 'post::themes.page',
            'data'         => compact('page'),
            'slug'         => $page->slug,
        ];
    }
}
