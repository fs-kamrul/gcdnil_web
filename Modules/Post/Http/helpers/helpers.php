<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Post\Supports\Template;


if (!defined('PAGE_MODULE_SCREEN_NAME')) {
    define('PAGE_MODULE_SCREEN_NAME', 'page');
}
if (!defined('PAGE_FILTER_FRONT_PAGE_CONTENT')) {
    define('PAGE_FILTER_FRONT_PAGE_CONTENT', 'page_front_page_content');
}
if (!defined('BRANCH_FILTER_FRONT_PAGE_CONTENT')) {
    define('BRANCH_FILTER_FRONT_PAGE_CONTENT', 'BRANCH_front_page_content');
}
if (!defined('PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST')) {
    define('PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST', 'page_name_in_admin_list');
}
if (!defined('POST_MODULE_SCREEN_NAME')) {
    define('POST_MODULE_SCREEN_NAME', 'post');
}
if (!defined('CATEGORY_MODULE_SCREEN_NAME')) {
    define('CATEGORY_MODULE_SCREEN_NAME', 'category');
}
if (!defined('RENDERING_THEME_OPTIONS_PAGE')) {
    define('RENDERING_THEME_OPTIONS_PAGE', 'rendering-theme-options-page');
}
if(! function_exists('createSlugFunction')) {
    function createSlugFunction($name,$model)
    {
        if (env('DEMO_MODE')) {
            return;
        }
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($model::where('slug', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }
        if (empty($slug)) {
            $slug = time();
        }
        return $slug;
    }
}
if(! function_exists('checkSlugFunction')) {
    function checkSlugFunction($name)
    {
        if (env('DEMO_MODE')) {
            return;
        }
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while (\Modules\KamrulDashboard\Http\Models\Slug::where('key', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }
        if (empty($slug)) {
            $slug = time();
        }
        return $slug;
    }
}
if (!function_exists('get_all_posts')) {
//    , 'categories.slugable'
    function get_all_posts($active = true, $perPage = 12, array $with = ['categories', 'user']) {
//        return app(PostInterface::class)->getAllPosts($perPage, $active, $with);
        $data = \Modules\Post\Http\Models\Post::with($with)
            ->orderBy('created_at', 'desc');
        if ($active) {
            $data = $data->where('status', 1);
        }
        return $data = $data->paginate($perPage);
    }
}

if (!function_exists('register_page_template')) {
    /**
     * @param array $templates
     * @return void
     */
    function register_page_template(array $templates)
    {
        Template::registerPageTemplate($templates);
    }
}

if (! function_exists('get_page_templates')) {
    function get_page_templates(): array
    {
        return \Modules\Post\Http\Models\PageTemplate::where('status', \Modules\KamrulDashboard\Packages\Supports\DboardStatus::PUBLISHED)->pluck('name','id')->toarray();
//        return Template::getPageTemplates();
    }
}
if (! function_exists('get_post_type')) {
    function get_post_type(): array
    {
        return \Modules\Post\Http\Models\PostType::where('status', \Modules\KamrulDashboard\Packages\Supports\DboardStatus::PUBLISHED)->pluck('name','id')->toarray();
//        return Template::getPageTemplates();
    }
}
if (!function_exists('get_popular_posts')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return \Illuminate\Support\Collection
     */
    function get_popular_posts($limit = 10, array $args = [])
    {
        return app(PostInterface::class)->getPopularPosts($limit, $args);
    }
}
if (!function_exists('get_posts_with_type')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return \Illuminate\Support\Collection
     */
    function get_posts_with_type($id, $paginate = 12, $limit = 0)
    {
        return app(PostInterface::class)->getPostsWithPostType($id, $paginate, $limit);
    }
}

if (!function_exists('get_galleries')) {
    /**
     * @param int $limit
     * @param array $with
     * @return \Illuminate\Support\Collection
     */
    function get_galleries(int $limit = 8, array $with = ['slug', 'user']): \Illuminate\Support\Collection
    {
        //..
//        return app(GalleryInterface::class)->getFeaturedGalleries($limit, $with);
    }
}
if (!function_exists('advancedGetData')) {
    function advancedGetData($model, array $params = []) {
        $params = array_merge([
            'condition' => [],
            'order_by'  => [],
            'take'      => null,
            'paginate'  => [
                'per_page'      => null,
                'current_paged' => 1,
            ],
            'select'    => ['*'],
            'with'      => [],
            'withCount' => [],
            'withAvg' => [],
        ], $params);
        applyConditionsData($params['condition'], $model);

        $data = $model;

        if ($params['select']) {
            $data = $data->select($params['select']);
        }

        foreach ($params['order_by'] as $column => $direction) {
            if (!in_array(strtolower($direction), ['asc', 'desc'])) {
                continue;
            }

            if ($direction !== null) {
                $data = $data->orderBy($column, $direction);
            }
        }

        if (!empty($params['with'])) {
            $data = $data->with($params['with']);
        }

        if (!empty($params['withCount'])) {
            $data = $data->withCount($params['withCount']);
        }

        if (!empty($params['withAvg'])) {
            $data = $data->withAvg($params['withAvg'][0], $params['withAvg'][1]);
        }

        if ($params['take'] == 1) {
            $result = $data->first();
        } elseif ($params['take']) {
            $result = $data->get();
        } elseif ($params['paginate']['per_page']) {
            $paginateType = 'paginate';
            if (Arr::get($params, 'paginate.type') && method_exists($data, Arr::get($params, 'paginate.type'))) {
                $paginateType = Arr::get($params, 'paginate.type');
            }
            $result = $data
                ->$paginateType(
                    (int)Arr::get($params, 'paginate.per_page', 10),
                    [],
                    'page',
                    (int)Arr::get($params, 'paginate.current_paged', 1)
                );
        } else {
            $result = $data->get();
        }

        return $result;
    }
}
if (!function_exists('applyConditionsData')) {
    function applyConditionsData(array $where, &$model = null) {
        if (!$model) {
            $newModel = '';
//            $newModel = $this->model;
        } else {
            $newModel = $model;
        }

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                [$field, $condition, $val] = $value;
                switch (strtoupper($condition)) {
                    case 'IN':
                        $newModel = $newModel->whereIn($field, $val);
                        break;
                    case 'NOT_IN':
                        $newModel = $newModel->whereNotIn($field, $val);
                        break;
                    default:
                        $newModel = $newModel->where($field, $condition, $val);
                        break;
                }
            } else {
                $newModel = $newModel->where($field, $value);
            }
        }

        if (!$model) {
            $model = $newModel;
        } else {
            $model = $newModel;
        }
    }
}
if (!function_exists('description_summary')) {
    function description_summary($str, $limit = 100, $strip = false)
    {
        $str = nl2br(strip_tags($str));
        $str = ($strip == true) ? strip_tags($str) : $str;
        if (strlen($str) > $limit) {
            $str = substr($str, 0, $limit - 3);
            return (substr($str, 0, strrpos($str, ' ')) . '...');
        }
        return trim($str);
    }
}

if (!function_exists('get_related_posts')) {
    /**
     * @param int $id
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    function get_related_posts($id, $limit)
    {
        return app(PostInterface::class)->getRelated($id, $limit);
    }
}
