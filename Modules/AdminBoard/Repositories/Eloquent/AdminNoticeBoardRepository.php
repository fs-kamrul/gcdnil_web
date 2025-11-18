<?php

namespace Modules\AdminBoard\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\AdminBoard\Repositories\Interfaces\AdminNoticeBoardInterface;
use Modules\KamrulDashboard\Http\Models\DboardQueryBuilder;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AdminNoticeBoardRepository extends RepositoriesAbstract implements AdminNoticeBoardInterface
{
     public function getAdminNoticeBoard($filters = [], $params = [])
     {
         $filters = array_merge([
             'keyword' => null,
             'min_floor' => null,
             'max_floor' => null,
             'blocks' => null,
             'min_flat' => null,
             'max_flat' => null,
             'category_id' => null,
             'search_query' => null,
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


         if ($filters['search_query'] !== null) {
             $search_query = $filters['search_query'];

//         dd($search_query);
             $this->model = $this->model
                 ->where(function($q) use ($search_query) {
                     $q->where('name', 'like', '%' . $search_query . '%')
                         ->orWhere('short_description', 'like', '%' . $search_query . '%')
                         ->orWhere('description', 'like', '%' . $search_query . '%');
                 });
//                 ->where(function (DboardQueryBuilder $query) use ($search_query) {
//                     return $query
//                         ->addSearch('name', $search_query, false, false)
//                         ->addSearch('description', $search_query, false);
//                 });
         }

         if ($filters['category_id'] != 0) {
             $categoryIds = get_noticeboard_categories_related_ids($filters['category_id']);
//             dd($categoryIds);
             $this->model = $this->model
                 ->whereHas('categories', function (Builder $query) use ($categoryIds) {
                     $query->whereIn('category_id', $categoryIds);
                 });
         }
         $this->model = apply_filters('AdminNoticeBoard_filter_query', $this->model, $filters, $params);

         return $this->advancedGet($params);
     }

     public function getRelatedAdminNoticeBoard(int $projectId, int $limit = 4, array $with = [])
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
