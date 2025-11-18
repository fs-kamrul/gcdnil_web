<?php

use Modules\AdminBoard\Enums\AdminNoticeBoardStatusEnum;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;
use Modules\AdminBoard\Enums\AdminCategoryStatusEnum;
use Modules\KamrulDashboard\Packages\Supports\SortItemsWithChildrenHelper;

if (! defined('ADMINBOARD_MODULE_SCREEN_NAME')) {
    define('ADMINBOARD_MODULE_SCREEN_NAME', 'adminboard');
}
if (! defined('ADMIN_BOARD_MODULE_SCREEN_NAME')) {
    define('ADMIN_BOARD_MODULE_SCREEN_NAME', 'AdminBoard');
}
if (! defined('ADMINGALLERYBOARD_MODULE_SCREEN_NAME')) {
    define('ADMINGALLERYBOARD_MODULE_SCREEN_NAME', 'admingalleryboard');
}

if (! defined('ADMINGALLERY_MODULE_SCREEN_NAME')) {
    define('ADMINGALLERY_MODULE_SCREEN_NAME', 'admingallery');
}

if (! defined('ADMINSTUDENTGUIDELINE_MODULE_SCREEN_NAME')) {
    define('ADMINSTUDENTGUIDELINE_MODULE_SCREEN_NAME', 'adminstudentguideline');
}

if (! defined('ADMINACADEMICGROUP_MODULE_SCREEN_NAME')) {
    define('ADMINACADEMICGROUP_MODULE_SCREEN_NAME', 'adminacademicgroup');
}

if (! defined('ADMINEDUCATION_MODULE_SCREEN_NAME')) {
    define('ADMINEDUCATION_MODULE_SCREEN_NAME', 'admineducation');
}

if (! defined('ADMINNOTICEBOARD_MODULE_SCREEN_NAME')) {
    define('ADMINNOTICEBOARD_MODULE_SCREEN_NAME', 'adminnoticeboard');
}

if (! defined('ADMINPARTNER_MODULE_SCREEN_NAME')) {
    define('ADMINPARTNER_MODULE_SCREEN_NAME', 'adminpartner');
}

if (! defined('ADMINTESTIMONIAL_MODULE_SCREEN_NAME')) {
    define('ADMINTESTIMONIAL_MODULE_SCREEN_NAME', 'admintestimonial');
}
if (! defined('ADMINCLUB_MODULE_SCREEN_NAME')) {
    define('ADMINCLUB_MODULE_SCREEN_NAME', 'adminclub');
}

if (! defined('ADMINFACILITY_MODULE_SCREEN_NAME')) {
    define('ADMINFACILITY_MODULE_SCREEN_NAME', 'adminfacility');
}

if (! defined('ADMINCAREERNAVIGATOR_MODULE_SCREEN_NAME')) {
    define('ADMINCAREERNAVIGATOR_MODULE_SCREEN_NAME', 'admincareernavigator');
}

if (! defined('ADMINCATEGORY_MODULE_SCREEN_NAME')) {
    define('ADMINCATEGORY_MODULE_SCREEN_NAME', 'admincategory');
}

if (! defined('ADMINTEAM_MODULE_SCREEN_NAME')) {
    define('ADMINTEAM_MODULE_SCREEN_NAME', 'adminteam');
}

if (! defined('ADMINEVENT_MODULE_SCREEN_NAME')) {
    define('ADMINEVENT_MODULE_SCREEN_NAME', 'adminevent');
}

if (! defined('ADMINNEWS_MODULE_SCREEN_NAME')) {
    define('ADMINNEWS_MODULE_SCREEN_NAME', 'adminnews');
}

if (! defined('ADMINWORKSHOP_MODULE_SCREEN_NAME')) {
    define('ADMINWORKSHOP_MODULE_SCREEN_NAME', 'adminworkshop');
}
use \Modules\AdminBoard\Http\Models\AdminGallery;

if (!function_exists('getAdminImageUrlById')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function getAdminImageUrlById($photo, $path = 'post')
    {
        $path_post = 'uploads/' . $path . '/';
        if($photo == ''){
            $photo_url = 'vendor/kamruldashboard/images/image-not-found.jpg';
        }else{
            $get_photo = AdminGallery::where('id', $photo)->first();
            if(!$get_photo)
                $photo_url = 'vendor/kamruldashboard/images/image-not-found.jpg';
            else
                $photo_url = $path_post . $get_photo->name;
        }
        return url($photo_url);
    }
}
if (! function_exists('get_admin_board_layouts')) {
    /**
     * @return string[]
     */
    function get_admin_board_layouts(): array
    {
        return [
            'admin-default' => __('Default'),
            'admin-page' => __('Page'),
//            'admin-right-sidebar' => __('Right Sidebar'),
//            'admin-left-sidebar' => __('Left Sidebar'),
//            'admin-full-width' => __('Full width'),
        ];
    }
}
if (! function_exists('getCategoryNames')) {
    /**
     * @return string[]
     */
    function getCategoryNames($noticeBoard)
    {
        // Fetch all categories from the $noticeBoard object
        $categories = $noticeBoard->categories;

        // Map over the categories to extract the name and prepend 'Notice Board ' to each category ID
        $categoryNames = $categories->map(function($category) {
            return $category->name; // Assuming each category has an 'id' field
        })->toArray();

        // Join the category names with commas
        return implode(', ', $categoryNames);
    }
}


if (! function_exists('get_teams_with_children')) {
    function get_teams_with_children($adminboard = 'team'): array
    {
        $categories = app(AdminCategoryInterface::class)
            ->allBy(['adminboard' => $adminboard, 'status' => AdminCategoryStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);

        return app(SortItemsWithChildrenHelper::class)
            ->setChildrenProperty('child_cats')
            ->setItems($categories)
            ->sort();
    }
}

if (! function_exists('get_news_with_children')) {
    function get_news_with_children($adminboard = 'news'): array
    {
        $categories = app(AdminCategoryInterface::class)
            ->allBy(['adminboard' => $adminboard, 'status' => AdminCategoryStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);

        return app(SortItemsWithChildrenHelper::class)
            ->setChildrenProperty('child_cats')
            ->setItems($categories)
            ->sort();
    }
}

if (! function_exists('get_noticeboard_categories_related_ids')) {
    function get_noticeboard_categories_related_ids($categoryId, array &$results = [], $categories = null): array {
        if ($categories instanceof \Illuminate\Support\Collection) {
            $list = $categories->where('parent_id', $categoryId);
            foreach ($list as $item) {
                $results[] = $item->id;

                $children = $categories->where('parent_id', $item->id);
                if ($children && $children->count()) {
                    $results = get_noticeboard_categories_related_ids($item->id, $results, $children);
                }
            }

            return $results;
        }

        $categories = app(AdminCategoryInterface::class)->allBy([
            'status' => AdminCategoryStatusEnum::PUBLISHED,
        ], [], ['id', 'parent_id']);

        $category = $categories->firstWhere('id', $categoryId);

        if ($category) {
            $results[] = $categoryId;
            $results = get_noticeboard_categories_related_ids($categoryId, $results, $categories);
        }

        return array_filter($results);
    }
}




