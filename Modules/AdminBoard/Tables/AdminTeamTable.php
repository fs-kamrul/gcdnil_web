<?php

namespace Modules\AdminBoard\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\AdminBoard\Enums\AdminTeamStatusEnum;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;
use Modules\AdminBoard\Repositories\Interfaces\AdminTeamInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class AdminTeamTable extends TableAbstract
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
     * AdminTeamTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param AdminTeamInterface $adminteamRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, AdminTeamInterface $adminteamRepository, AdminCategoryInterface $adminCategoryRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $adminteamRepository;
        $this->adminCategoryRepository = $adminCategoryRepository;

        if (!Auth::user()->can(['adminteam_edit', 'adminteam_destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {

        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (! Auth::user()->can('adminteam_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('adminteam.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
            ->editColumn('photo', function ($item) {
                $photo_path = 'adminboard/adminteam';
                $photo = getImageUrl($item->photo,$photo_path);
                return $this->displayThumbnail(url($photo));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('updated_at', function ($item) {
                $categories = '';
                foreach ($item->categories as $category) {
                    $categories .= Html::link(route('category.edit', $category->id), $category->name) . ', ';
                }

                return rtrim($categories, ', ');
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->editColumn('user_id', function ($item) {
                return $item->user && $item->user->name ? clean($item->user->name) : '&mdash;';
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('adminteam.edit', 'adminteam.destroy', $item);
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
            'order',
            'created_at',
            'user_id',
            'status',
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
            'order' => [
                'title' => trans('table::lang.order'),
                'class' => 'text-start',
            ],
            'updated_at' => [
                'title'     => trans('table::lang.categories'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            'user_id'  => [
                'title'     => trans('table::lang.author'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
        ];
    }

    public function buttons()
    {
        return $this->addCreateButton(route('adminteam.create'), 'adminteam_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('adminteam.deletes'), 'adminteam_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'type' => 'customSelect',
                'choices' => AdminTeamStatusEnum::labels(),
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
    public function getCategories(): array
    {
        return $this->adminCategoryRepository->getCategoriesByBoard('team');
    }
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

                if (!DboardHelper::isJoined($query, 'admin_team_categories')) {
                    $query = $query
                        ->join('admin_team_categories', 'admin_team_categories.team_id', '=', 'admin_teams.id')
                        ->join('admin_categories', 'admin_team_categories.category_id', '=', 'admin_categories.id')
                        ->select($query->getModel()->getTable() . '.*');
                }

                return $query->where('admin_team_categories.category_id', $value);
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
}
