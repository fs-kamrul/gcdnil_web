<?php

namespace Modules\AdminBoard\Repositories\Eloquent;

use Modules\AdminBoard\Repositories\Interfaces\AdminEventInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AdminEventRepository extends RepositoriesAbstract implements AdminEventInterface
{
    public function getEvent($filters = [], $params = [])
    {
        $filters = array_merge([
            'keyword' => null,
            'min_floor' => null,
            'max_floor' => null,
            'blocks' => null,
            'min_flat' => null,
            'max_flat' => null,
            'category_id' => null,
            'city_id' => null,
            'city' => null,
            'min_price' => null,
            'max_price' => null,
//            'state' => null,
//            'state_id' => null,
            'location' => null,
            'sort_by' => null,
        ], $filters);

        $sortBy = isset($filters['sort_by']) ? $filters['sort_by'] : null;

        switch ($sortBy) {
            case 'date_asc':
                $orderBy = [
                    'created_at' => 'ASC',
                ];
                break;
//            case 'price_asc':
//                $orderBy = [
//                    'price_from' => 'ASC',
//                ];
//                break;
//            case 'price_desc':
//                $orderBy = [
//                    'price_from' => 'DESC',
//                ];
//                break;
//            case 'name_asc':
//                $orderBy = [
//                    'name' => 'ASC',
//                ];
//                break;
//            case 'name_desc':
//                $orderBy = [
//                    'name' => 'DESC',
//                ];
//                break;
            default:
                $orderBy = [
                    'start_date' => 'DESC',
                ];
                break;
        }
        $params = array_merge([
            'condition' => [],
            'order_by' => [
                'start_date' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => 10,
                'current_paged' => 1,
            ],
            'select' => [
                '*',
            ],
            'with' => [],
        ], $params);

        $params['order_by'] = $orderBy;

        $this->model = $this->originalModel;

        $this->model = $this->model->active();


        $this->model = apply_filters('event_filter_query', $this->model, $filters, $params);

        return $this->advancedGet($params);
    }

    public function getRelatedEvent(int $projectId, int $limit = 4, array $with = [])
    {
        $currentProject = $this->findById($projectId, ['categories']);

        $this->model = $this->originalModel;
        $this->model = $this->model
            ->active()
            ->whereNot('id', $projectId);

//        if ($currentProject && $currentProject->categories->count()) {
//            $categoryIds = $currentEvent->categories->pluck('id')->toArray();
//
//            $this->model
//                ->whereHas('categories', function ($query) use ($categoryIds) {
//                    $query->whereIn('Event_categories.category_id', $categoryIds);
//                });
//        }

        $params = [
            'condition' => [],
            'order_by' => [
                'start_date' => 'DESC',
            ],
            'take' => $limit,
            'with' => $with,
        ];

        return $this->advancedGet($params);
    }
    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('slug', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        $this->resetModel();

        return $slug;
    }
}
