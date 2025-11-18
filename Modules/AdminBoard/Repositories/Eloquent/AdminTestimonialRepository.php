<?php

namespace Modules\AdminBoard\Repositories\Eloquent;

use Modules\AdminBoard\Repositories\Interfaces\AdminTestimonialInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AdminTestimonialRepository extends RepositoriesAbstract implements AdminTestimonialInterface
{
     public function getAdminTestimonial($filters = [], $params = [])
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
                     'created_at' => 'ASC',
                 ];
                 break;
             default:
                 $orderBy = [
                     'created_at' => 'DESC',
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


         $this->model = apply_filters('AdminTestimonial_filter_query', $this->model, $filters, $params);

         return $this->advancedGet($params);
     }

     public function getRelatedAdminTestimonial(int $projectId, int $limit = 4, array $with = [])
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
