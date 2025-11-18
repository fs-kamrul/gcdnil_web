<?php

namespace Modules\SimpleSlider\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class SimpleSliderTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        SimpleSliderInterface $simpleSliderRepository
    ) {
        parent::__construct($table, $urlGenerator);

        $this->repository = $simpleSliderRepository;

        if (! Auth::user()->can(['simple-slider_edit', 'simple-slider_destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): \Illuminate\Http\JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (! Auth::user()->can('simple-slider_edit')) {
                    return DboardHelper::clean($item->name);
                }

                return Html::link(route('simple-slider.edit', $item->id), DboardHelper::clean($item->name));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('simple-slider.edit', 'simple-slider.destroy', $item);
            });

        if (function_exists('shortcode')) {
            $data = $data->editColumn('key', function ($item) {
                return shortcode()->generateShortcode('simple-slider', ['key' => $item->key]);
            });
        }

        return $this->toJson($data);
    }

    public function query()
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            'key',
            'status',
            'created_at',
        ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('kamruldashboard::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => trans('kamruldashboard::tables.name'),
                'class' => 'text-start',
            ],
            'key' => [
                'title' => trans('simpleslider::simple-slider.key'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('kamruldashboard::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('kamruldashboard::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('simple-slider.create'), 'simple-slider.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('simple-slider.deletes'), 'simple-slider.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('kamruldashboard::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'key' => [
                'title' => trans('simpleslider::simple-slider.key'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('kamruldashboard::tables.status'),
                'type' => 'customSelect',
                'choices' => DboardStatus::labels(),
                'validate' => 'required|' . Rule::in(DboardStatus::values()),
            ],
            'created_at' => [
                'title' => trans('kamruldashboard::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
