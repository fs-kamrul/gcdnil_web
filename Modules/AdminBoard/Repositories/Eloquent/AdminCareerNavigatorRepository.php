<?php

namespace Modules\AdminBoard\Repositories\Eloquent;

use Modules\AdminBoard\Repositories\Interfaces\AdminCareerNavigatorInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AdminCareerNavigatorRepository extends RepositoriesAbstract implements AdminCareerNavigatorInterface
{
     public function getAdminCareerNavigator($filters = [], $params = [])
     {
         $filters = array_merge([
             'keyword' => null,
             'min_floor' => null,
             'max_floor' => null,
             'blocks' => null,
             'min_flat' => null,
             'max_flat' => null,
             'category_id' => null,
             'location' => null,
             'sort_by' => null,
         ], $filters);

         $sortBy = isset($filters['sort_by']) ? $filters['sort_by'] : null;

         switch ($sortBy) {
             case 'date_asc':
                 $orderBy = [
                     'start_date' => 'ASC',
                 ];
                 break;
             default:
                 $orderBy = [
                     'start_date' => 'DESC',
                 ];
                 break;
         }
         $params = array_merge([
             'condition' => [],
             'order_by' => [
                 'created_at' => 'DESC',
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


         $this->model = apply_filters('AdminCareerNavigator_filter_query', $this->model, $filters, $params);

         return $this->advancedGet($params);
     }

     public function getRelatedAdminCareerNavigator(int $projectId, int $limit = 4, array $with = [])
     {
         $currentProject = $this->findById($projectId, ['categories']);

         $this->model = $this->originalModel;
         $this->model = $this->model
             ->active()
             ->whereNot('id', $projectId);

         $params = [
             'condition' => [],
             'order_by' => [
                 'created_at' => 'DESC',
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
