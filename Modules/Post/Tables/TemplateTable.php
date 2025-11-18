<?php

namespace Modules\Post\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Repositories\Interfaces\PageTemplateInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class TemplateTable extends TableAbstract
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
     * TemplateTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PageTemplateInterface $pagetemplateRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, PageTemplateInterface $pagetemplateRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $pagetemplateRepository;

        if (!Auth::user()->can(['pagetemplate_edit', 'pagetemplate_destroy'])) {
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
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->addColumn('operations', function ($item) {
                //pagetemplate.edit
                return $this->getOperations('', 'pagetemplate.destroy', $item);
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
            'created_at',
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
            'name' => [
                'title' => trans('table::lang.name'),
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
        ];
    }

    public function buttons()
    {
//        return $this->addCreateButton(route('pagetemplate.create'), 'pagetemplate_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('pagetemplate.deletes'), 'pagetemplate_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
//            'name' => [
//                'title' => trans('table::lang.name'),
//                'type' => 'text',
//                'validate' => 'required|max:120',
//            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'type' => 'customSelect',
                'choices' => array_status(),
                'validate' => 'required',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
}
