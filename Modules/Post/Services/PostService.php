<?php

namespace Modules\Post\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Branch\Http\Models\Branch;
use Modules\Branch\Repositories\Interfaces\BranchInterface;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Post;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\SeoHelper\Packages\Supports\SeoOpenGraph;
use SeoHelper;
use Theme;

class PostService
{
    /**
     * @param Slug $slug
     * @return array|Model
     */
    public function handleFrontRoutes($slug)
    {
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

        switch ($slug->reference_type) {
            case Post::class:
                $post = app(PostInterface::class)
                    ->getFirstBy($condition, ['*'],
                        ['categories']);

                if (empty($post)) {
                    abort(404);
                }

//                dd($post->url);
//                DboardHelper::handleViewCount($post, 'viewed_post');

                SeoHelper::setTitle($post->name)
                    ->setDescription($post->short_description);

                $meta = new SeoOpenGraph;
                if ($post->photo) {
                    $meta->setImage(url(getImageUrl($post->photo, 'post')));
                }
                $meta->setDescription($post->short_description);
                $meta->setUrl($post->slug);
                $meta->setTitle($post->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

                if (function_exists('admin_bar') && Auth::check() && auth()->user()->can('page_edit')) {
//                    admin_bar()->registerLink(trans('post::posts.edit_this_post'),
//                        route('posts.edit', $post->id));
                    admin_bar()
                        ->registerLink(trans('post::lang.edit_this_page'), url('post/' . $post->id . "/edit"));
                }

                Theme::breadcrumb()->add(__('Home'), route('public.index'));

                $category = $post->categories->sortByDesc('id')->first();
                if ($category) {

//                    if ($category->parents->count()) {
//                        foreach ($category->parents as $parentCategory) {
//                            Theme::breadcrumb()->add($parentCategory->name, $parentCategory->slug);
//                        }
//                    }

                    Theme::breadcrumb()->add($category->name, $category->slug);
                }

                Theme::breadcrumb()->add(SeoHelper::getTitle(), $post->slug);

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, POST_MODULE_SCREEN_NAME, $post);

                return [
                    'view'         => 'post_up',
                    'default_view' => 'post::themes.post',
                    'data'         => compact('post'),
                    'slug'         => $post->slug,
                ];
            case Category::class:
                $category = app(CategoryInterface::class)
                    ->getFirstBy($condition, ['*']);

                if (empty($category)) {
                    abort(404);
                }

                SeoHelper::setTitle($category->name)
                    ->setDescription($category->short_description);

                $meta = new SeoOpenGraph;
                if ($category->photo) {
                    $meta->setImage(url(getImageUrl($category->photo, 'post/category')));
                }
                $meta->setDescription($category->short_description);
                $meta->setUrl($category->url);
                $meta->setTitle($category->name);
                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

                if (function_exists('admin_bar') && Auth::check() && auth()->user()->can('category.edit')) {
                    admin_bar()
                        ->registerLink(trans('post::lang.edit_this_page'), url('category/' . $category->id . "/edit"));
                }
                $allRelatedCategoryIds = $category->getChildrenIds($category, [$category->id]);

                $posts = app(PostInterface::class)
                    ->getByCategory($allRelatedCategoryIds, (int)theme_option('number_of_post', 12));

                Theme::breadcrumb()
                    ->add(__('Home'), route('public.index'));

                if ($category->parents->count()) {
                    foreach ($category->parents->reverse() as $parentCategory) {
                        Theme::breadcrumb()->add($parentCategory->name, $parentCategory->slug);
                    }
                }
//                Theme::breadcrumb()->add($category->name, $category->slug);

                Theme::breadcrumb()->add(SeoHelper::getTitle(), $category->slug);

                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, CATEGORY_MODULE_SCREEN_NAME, $category);

                return [
                    'view'         => 'category',
                    'default_view' => 'post::themes.category',
                    'data'         => compact('category', 'posts'),
                    'slug'         => $category->slug,
                ];

            case Branch::class:
                $branch = app(BranchInterface::class)
                    ->getFirstBy($condition, ['*']);

                if (empty($branch)) {
                    abort(404);
                }

                SeoHelper::setTitle($branch->name)
                    ->setDescription($branch->short_description);

                $meta = new SeoOpenGraph;
                if ($branch->photo) {
                    $meta->setImage(url(getImageUrl($branch->photo, 'branch')));
                }
                $meta->setDescription($branch->short_description);
                $meta->setUrl($branch->slug);
                $meta->setTitle($branch->name);
//                $meta->setType('article');

                SeoHelper::setSeoOpenGraph($meta);

//                if (function_exists('admin_bar') && Auth::check() && auth()->user()->can('page_edit')) {
//                    admin_bar()->registerLink(trans('post::posts.edit_this_post'),
//                        route('posts.edit', $branch->id));
//                    admin_bar()
//                        ->registerLink(trans('post::lang.edit_this_page'), url('branch/' . $branch->id . "/edit"));
//                }

                Theme::breadcrumb()->add(__('Home'), route('public.index'));

//                $category = $post->categories->sortByDesc('id')->first();
//                if ($category) {

//                    if ($category->parents->count()) {
//                        foreach ($category->parents as $parentCategory) {
//                            Theme::breadcrumb()->add($parentCategory->name, $parentCategory->url);
//                        }
//                    }

//                    Theme::breadcrumb()->add($category->name, $category->url);
//                }

                Theme::breadcrumb()->add(SeoHelper::getTitle(), $branch->slug);
                Theme::uses(Theme::getThemeName())
                    ->layout('branch');
                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, POST_MODULE_SCREEN_NAME, $branch);

                return [
                    'view'         => 'branch',
                    'default_view' => 'post::themes.branch',
                    'data'         => compact('branch'),
                    'slug'         => $branch->slug,
                ];

//            case Tag::class:
//                $tag = app(TagInterface::class)->getFirstBy($condition, ['*'], ['slugable']);
//
//                if (!$tag) {
//                    abort(404);
//                }
//
//                SeoHelper::setTitle($tag->name)
//                    ->setDescription($tag->description);
//
//                $meta = new SeoOpenGraph;
//                $meta->setDescription($tag->description);
//                $meta->setUrl($tag->url);
//                $meta->setTitle($tag->name);
//                $meta->setType('article');
//
//                if (function_exists('admin_bar') && Auth::check() && Auth::user()->hasPermission('tags.edit')) {
//                    admin_bar()->registerLink(trans('blog::tags.edit_this_tag'), route('tags.edit', $tag->id));
//                }
//
//                $posts = get_posts_by_tag($tag->id, (int)theme_option('number_of_posts_in_a_tag', 12));
//
//                Theme::breadcrumb()
//                    ->add(__('Home'), route('public.index'))
//                    ->add(SeoHelper::getTitle(), $tag->url);
//
//                do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, TAG_MODULE_SCREEN_NAME, $tag);
//
//                return [
//                    'view'         => 'tag',
//                    'default_view' => 'blog::themes.tag',
//                    'data'         => compact('tag', 'posts'),
//                    'slug'         => $tag->slug,
//                ];
        }

        return $slug;
    }
}
