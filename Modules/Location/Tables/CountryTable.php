<?php

namespace Modules\Location\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Location\Repositories\Interfaces\CountryInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class CountryTable extends TableAbstract
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
     * CountryTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param CountryInterface $countryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, CountryInterface $countryRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $countryRepository;

        if (!Auth::user()->can(['country_edit', 'country_destroy'])) {
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
                if (! Auth::user()->can('country_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('country.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
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
                return $this->getOperations('country.edit', 'country.destroy', $item);
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
            'nationality',
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
            'nationality' => [
                'title' => trans('location::country.nationality'),
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
        return $this->addCreateButton(route('country.create'), 'country_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('country.deletes'), 'country_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'nationality' => [
                'title' => trans('location::country.nationality'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
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
