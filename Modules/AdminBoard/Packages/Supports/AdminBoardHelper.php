<?php

namespace Modules\AdminBoard\Packages\Supports;


use Illuminate\Contracts\Database\Query\Builder;
use Modules\AdminBoard\Repositories\Interfaces\AdminCareerNavigatorInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminClubInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminGalleryBoardInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminStudentGuidelineInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminAcademicGroupInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminNoticeBoardInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminTeamInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminWorkshopInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminNewsInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminEventInterface;

class AdminBoardHelper
{

    public function getAdminWorkshopRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }

    public function getWorkshopFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('workshops_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'state_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_workshops.created_at' => 'DESC'],
            'with' => self::getWorkshopRelationsQuery(),
        ], $extra);

        return app(AdminWorkshopInterface::class)->getWorkshop($filters, $params);
    }

    public function getWorkshopRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }

    public function getAdminNoticeBoardRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getNoticeBoardFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('notice_boards_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'state_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

//        $filters['category_id'] = $request->input('category_id');
        $filters['search_query'] = $request->input('search_query');
//        $filters['keyword'] = $request->input('k');

//        dd($filters);
        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_notice_boards.created_at' => 'DESC'],
            'with' => self::getNoticeBoardRelationsQuery(),
        ], $extra);

        return app(AdminNoticeBoardInterface::class)->getAdminNoticeBoard($filters, $params);
    }

    public function getNoticeBoardRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getNewsFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('newses_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_news.created_at' => 'DESC'],
            'with' => self::getAdminNewsRelationsQuery(),
        ], $extra);

        return app(AdminNewsInterface::class)->getNews($filters, $params);
    }

    public function getAdminNewsRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getEventFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('events_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_events.start_date' => 'DESC'],
            'with' => self::getAdminEventRelationsQuery(),
        ], $extra);

        return app(AdminEventInterface::class)->getEvent($filters, $params);
    }

    public function getAdminEventRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getGalleryBoardFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('galleries_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_galleries.start_date' => 'DESC'],
            'with' => self::getAdminGalleryBoardRelationsQuery(),
        ], $extra);

        return app(AdminGalleryBoardInterface::class)->getAdminGalleryBoard($filters, $params);
    }

    public function getAdminGalleryBoardRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getCareerNavigatorFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('career_navigators_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_career_navigators.created_at' => 'DESC'],
            'with' => self::getAdminCareerNavigatorRelationsQuery(),
        ], $extra);

        return app(AdminCareerNavigatorInterface::class)->getAdminCareerNavigator($filters, $params);
    }

    public function getAdminCareerNavigatorRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getStudentGuidelineFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('career_navigators_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_career_navigators.created_at' => 'DESC'],
//            'with' => self::getAdminStudentGuidelineRelationsQuery(),
        ], $extra);

        return app(AdminStudentGuidelineInterface::class)->getAdminStudentGuideline($filters, $params);
    }

    public function getAdminStudentGuidelineRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getAcademicGroupFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('projects_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_career_navigators.created_at' => 'DESC'],
            'with' => self::getAdminAcademicGroupRelationsQuery(),
        ], $extra);

        return app(AdminAcademicGroupInterface::class)->getAdminAcademicGroup($filters, $params);
    }

    public function getAdminAcademicGroupRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getTeamFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('projects_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
            'category_ids' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
//            'condition' => ['adminboard'=>'team'],
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_teams.created_at' => 'DESC'],
            'with' => self::getAdminTeamRelationsQuery(),
        ], $extra);

        return app(AdminTeamInterface::class)->getAdminTeam($filters, $params);
    }

    public function getAdminTeamRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
            'categories' => function (\Illuminate\Database\Eloquent\Relations\BelongsToMany $query) {
                return $query
                    ->where('adminboard', 'team')
//                    ->wherePublished()
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('is_default', 'DESC')
                    ->orderBy('order', 'ASC')
                    ->select('admin_categories.id', 'admin_categories.name');
            },
        ];
    }

    public function getCategoryFilter(?int $perPage = 12, int $category = null)
    {
        $request = request();
        $perPage = (int) $request->input('per_page', $perPage ?: 12);
        $conditions['adminboard'] = 'team';
        if($category){
            $conditions['id'] = $category;
        }
//        dd($conditions);
        $team = app(AdminCategoryInterface::class)->advancedGet([
            'condition' => $conditions,
            'take'      => 1,
//            'order_by' => ['created_at' => 'desc'],
        ]);
//        $teams = AdminBoardHelper::getCategoryFilter((int) theme_option('number_of_team_per_page') ?: 12, []);
        $teams = $team->adminteams()->orderBy('order', 'ASC')->Paginate($perPage);

        return $teams;
//        return app(AdminCategoryInterface::class)->getAdminCategory([], [], $conditions);
    }

    public function getAdminCategoryRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
            'categories' => function (\Illuminate\Database\Eloquent\Relations\BelongsToMany $query) {
                return $query
//                    ->where('adminboard', 'team')
//                    ->wherePublished()
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
                    ->select('admin_categories.id', 'admin_categories.name');
            },
        ];
    }

    public function getAdminClubFilter(?int $perPage = 12, array $extra = [])
    {
        $request = request();

//        $perPage = $request->integer('per_page') ?: ($perPage ?: 12);
        $perPage = (int) $request->input('per_page', $perPage ?: 12);

        $filters = $request->validate(apply_filters('projects_filter_validation_rules', [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'blocks' => 'nullable|numeric',
            'locations' => 'nullable|array',
        ]));

        $filters['keyword'] = $request->input('k');

        $params = array_merge([
            'paginate' => [
                'per_page' => (int) $perPage,  // Ensure perPage is an integer
                'current_paged' => (int) $request->input('page', 1), // Cast to integer
            ],
            'order_by' => ['admin_clubs.created_at' => 'DESC'],
            'with' => self::getAdminClubRelationsQuery(),
        ], $extra);

        return app(AdminClubInterface::class)->getAdminClubGroup($filters, $params);
    }

    public function getAdminClubRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
//            'state:id,name',
//            'city:id,name',
//            'categories' => function (Builder $query) {
//                return $query
//                    ->wherePublished()
//                    ->orderBy('created_at', 'DESC')
//                    ->orderBy('is_default', 'DESC')
//                    ->orderBy('order', 'ASC')
//                    ->select('re_categories.id', 're_categories.name');
//            },
        ];
    }
    public function getPropertiesPerPageList(): array
    {
        return apply_filters(PROPERTIES_PER_PAGE_LIST, [
            9 => 9,
            12 => 12,
            15 => 15,
            30 => 30,
            45 => 45,
            60 => 60,
            120 => 120,
        ]);
    }
    public function getSortByList(): array
    {
        return [
            'date_asc' => __('Oldest'),
            'date_desc' => __('Newest'),
            'price_asc' => __('Price (low to high)'),
            'price_desc' => __('Price (high to low)'),
            'name_asc' => __('Name (A-Z)'),
            'name_desc' => __('Name (Z-A)'),
        ];
    }
}
