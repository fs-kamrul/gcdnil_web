<?php

namespace Modules\Location\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Location\Repositories\Interfaces\CountryInterface;
use Modules\Location\Repositories\Interfaces\StateInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;
use Location;

class StateTable extends TableAbstract
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
     * StateTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param StateInterface $stateRepository
     * @param CountryInterface $countryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, StateInterface $stateRepository, CountryInterface $countryRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $stateRepository;
        $this->countryRepository = $countryRepository;

        if (!Auth::user()->can(['state_edit', 'state_destroy'])) {
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
                if (! Auth::user()->can('state_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('state.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
            ->editColumn('country_id', function ($item) {
                if (! $item->country_id && $item->country->name) {
                    return null;
                }

                return Html::link(route('country.edit', $item->country_id), $item->country->name);
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
                return $this->getOperations('state.edit', 'state.destroy', $item);
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
            'country_id',
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
            'country_id' => [
                'title' => trans('location::state.country'),
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
        return $this->addCreateButton(route('state.create'), 'state_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('state.deletes'), 'state_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'country_id' => [
                'title' => trans('location::state.country'),
                'type' => 'customSelect',
                'choices' => Location::getCountry(),
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
