<?php

namespace Modules\AdminBoard\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\AdminBoard\Enums\AdminFacilityStatusEnum;
use Modules\AdminBoard\Repositories\Interfaces\AdminFacilityInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class AdminFacilityTable extends TableAbstract
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
     * AdminFacilityTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param AdminFacilityInterface $adminfacilityRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, AdminFacilityInterface $adminfacilityRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $adminfacilityRepository;

        if (!Auth::user()->can(['adminfacility_edit', 'adminfacility_destroy'])) {
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
                if (! Auth::user()->can('adminfacility_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('adminfacility.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
//            ->editColumn('photo', function ($item) {
//                $photo_path = 'AdminBoard/adminfacility';
//                $photo = getImageUrl($item->photo,$photo_path);
//                return $this->displayThumbnail(url($photo));
//            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
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
                return $this->getOperations('adminfacility.edit', 'adminfacility.destroy', $item);
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
//            'photo'      => [
//                'title' => trans('table::lang.image'),
//                'width' => '70px',
//            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'order' => [
                'title' => trans('table::lang.order'),
                'class' => 'text-start',
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
        return $this->addCreateButton(route('adminfacility.create'), 'adminfacility_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('adminfacility.deletes'), 'adminfacility_destroy', parent::bulkActions());
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
                'choices' => AdminFacilityStatusEnum::labels(),
                'validate' => 'required',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
}
