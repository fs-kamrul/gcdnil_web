<?php

namespace Modules\Post\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Repositories\Interfaces\PageInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class PageTable extends TableAbstract
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
     * PageTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PageInterface $pageRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, PageInterface $pageRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $pageRepository;

        if (!Auth::user()->can(['page_edit', 'page_destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $pageTemplates = get_page_templates();
        $statusDesign = get_status_design();

//        dd($statusDesign);
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (! Auth::user()->can('page_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('page.edit', $item->id), DboardHelper::clean($item->name));
                }

                if (function_exists('theme_option') && DboardHelper::isHomepage($item->id)) {
                    $name .= Html::tag('span', ' — ' . trans('post::lang.front_page'), [
                        'class' => 'additional-page-name',
                    ])->toHtml();
                }

                return apply_filters(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, $name, $item);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('page_templates_id', function ($item) use ($pageTemplates) {
//                dd($item->page_templates->slug);
//                return Arr::get($pageTemplates, $item->page_templates->slug ?: 'default');
                return $item->page_templates->name;
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
//                dd($item->status);
                return DboardHelper::clean($item->status->toHtml());
//                dd(Arr::get($statusDesign, 0 , __('In active')));
//                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('page.edit', 'page.destroy', $item);
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
            'page_templates_id',
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
            'page_templates_id' => [
                'title' => trans('table::lang.template'),
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
        return $this->addCreateButton(route('page.create'), 'page_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('page.deletes'), 'page_destroy', parent::bulkActions());
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
                'choices' => array_status(),
                'validate' => 'required',
            ],
            'page_templates_id' => [
                'title' => trans('table::lang.template'),
                'type' => 'customSelect',
                'choices' => get_page_templates(),
                'validate' => 'required',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
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
