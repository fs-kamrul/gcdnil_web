<?php

namespace Modules\SimpleSlider\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class SimpleSliderItemTable extends TableAbstract
{
    protected $type = self::TABLE_TYPE_SIMPLE;

    protected $view = 'simpleslider::items';

    protected $repository;

    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        SimpleSliderItemInterface $simpleSliderItemRepository
    ) {
        parent::__construct($table, $urlGenerator);
        $this->setOption('id', 'simple-slider-items-table');

        $this->repository = $simpleSliderItemRepository;

        if (! Auth::user()->can(['simple-slideritem_edit', 'simple-slideritem_destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('image', function ($item) {
                return view('simpleslider::partials.thumbnail', compact('item'))->render();
            })
            ->editColumn('title', function ($item) {
                if (! Auth::user()->can('simple-slideritem_edit')) {
                    return DboardHelper::clean($item->title);
                }

                return Html::link('#', DboardHelper::clean($item->title), [
                    'data-fancybox' => true,
                    'data-type' => 'ajax',
                    'data-src' => route('simple-slider-item.edit', $item->id),
                ]);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->addColumn('operations', function ($item) {
                return view('simpleslider::partials.actions', compact('item'))->render();
            });

        return $this->toJson($data);
    }

    public function query()
    {
        $query = $this->repository->getModel()
            ->select([
                'id',
                'title',
                'image',
                'order',
                'created_at',
            ])
            ->orderBy('order')
            ->where('simple_slider_id', request()->route()->parameter('id'));

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
                'id' => [
                    'title' => trans('kamruldashboard::tables.id'),
                    'width' => '20px',
                ],
                'image' => [
                    'title' => trans('kamruldashboard::tables.image'),
                    'class' => 'text-center',
                ],
                'title' => [
                    'title' => trans('kamruldashboard::tables.title'),
                    'class' => 'text-start',
                ],
                'order' => [
                    'title' => trans('kamruldashboard::tables.order'),
                    'class' => 'text-start order-column',
                ],
                'created_at' => [
                    'title' => trans('kamruldashboard::tables.created_at'),
                    'width' => '100px',
                ],
            ] + $this->getOperationsHeading();
    }

    public function getOperationsHeading(): array
    {
        return array_merge(parent::getOperationsHeading(), ['operations' => ['width' => '170px']]);
    }
}
