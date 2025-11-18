<?php

namespace Modules\Location\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Location\Repositories\Interfaces\CityInterface;
use Modules\Location\Repositories\Interfaces\CountryInterface;
use Modules\Location\Repositories\Interfaces\StateInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;
use Location;

class CityTable extends TableAbstract
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
     * CityTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param CityInterface $cityRepository
     * @param CountryInterface $countryRepository
     * @param StateInterface $stateRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        CityInterface $cityRepository,
        CountryInterface $countryRepository,
        StateInterface $stateRepository
    )
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $cityRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;

        if (!Auth::user()->can(['city_edit', 'city_destroy'])) {
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
                if (! Auth::user()->can('city_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('city.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('state_id', function ($item) {
                if (! $item->state_id || ! $item->state->name) {
                    return '&mdash;';
                }

                return Html::link(route('state.edit', $item->state_id), $item->state->name);
            })
            ->editColumn('country_id', function ($item) {
                if (! $item->country_id || ! $item->country->name) {
                    return '&mdash;';
                }

                return Html::link(route('country.edit', $item->country_id), $item->country->name);
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('city.edit', 'city.destroy', $item);
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
            'state_id',
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
            'state_id' => [
                'title' => trans('location::city.state'),
                'class' => 'text-start',
            ],
            'country_id' => [
                'title' => trans('location::city.country'),
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
        return $this->addCreateButton(route('city.create'), 'city_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('city.deletes'), 'city_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'state_id' => [
                'title' => trans('location::city.state'),
                'type' => 'customSelect',
                'choices' => Location::getStates(),
                'validate' => 'required|max:120',
            ],
            'country_id' => [
                'title' => trans('location::city.country'),
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
