<?php

namespace Modules\Post\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class PostTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;
    /**
     * PostTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PostInterface $postRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, PostInterface $postRepository, CategoryInterface $categoryRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $postRepository;
        $this->categoryRepository = $categoryRepository;

        if (!Auth::user()->can(['post_edit', 'post_destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $statusDesign = get_status_design();

        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (! Auth::user()->can('post_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('post.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
            ->editColumn('photo', function ($item) {
                $photo_path = 'uploads/post/';
                if($item->photo == ''){
                    $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
                }else{
                    $photo = $photo_path . $item->photo;
                }
                return $this->displayThumbnail(url($photo));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('post_types_id', function ($item) {
                return $item->post_types->name;
            })
            ->editColumn('user_id', function ($item) {
                return $item->user && $item->user->name ? clean($item->user->name) : '&mdash;';
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('updated_at', function ($item) {
                $categories = '';
                foreach ($item->categories as $category) {
                    $categories .= Html::link(route('category.edit', $category->id), $category->name) . ', ';
                }

                return rtrim($categories, ', ');
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('post.edit', 'post.destroy', $item);
            });

        return $this->toJson($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            'photo',
            'post_types_id',
            'created_at',
            'status',
            'user_id',
            'updated_at',
        ]);

        return $this->applyScopes($query);
    }

    public function columns()
    {
        return [
            'id' => [
                'title' => trans('table::lang.id'),
                'width' => '20px',
            ],
            'photo'      => [
                'title' => trans('table::lang.image'),
                'width' => '70px',
            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'post_types_id' => [
                'title' => trans('post::lang.posttype'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            'updated_at' => [
                'title'     => trans('table::lang.categories'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'user_id'  => [
                'title'     => trans('table::lang.author'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'width' => '100px',
                'class' => 'text-center',
            ],
        ];
    }

    public function buttons()
    {
        return $this->addCreateButton(route('post.create'), 'post_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('post.deletes'), 'post_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'post_types_id' => [
                'title' => trans('post::lang.posttype'),
                'type' => 'customSelect',
                'choices' => get_post_type(),
                'validate' => 'required',
            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'type' => 'customSelect',
                'choices' => array_status(),
                'validate' => 'required',
            ],
            'category'         => [
                'title'    => trans('table::lang.category'),
                'type'     => 'select-search',
                'validate' => 'required',
                'callback' => 'getCategories',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->pluck('name', 'id');
    }
    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'created_at':
                if (!$value) {
                    break;
                }

                $value = DboardHelper::formatDate($value);

                return $query->whereDate($key, $operator, $value);
            case 'category':
                if (!$value) {
                    break;
                }

                if (!DboardHelper::isJoined($query, 'post_categories')) {
                    $query = $query
                        ->join('post_categories', 'post_categories.post_id', '=', 'posts.id')
                        ->join('categories', 'post_categories.category_id', '=', 'categories.id')
                        ->select($query->getModel()->getTable() . '.*');
                }

                return $query->where('post_categories.category_id', $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }
    /**
     * {@inheritDoc}
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'category') {
            $item->categories()->sync([$inputValue]);

            return $item;
        }

        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
