<?php

namespace Modules\Faq\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class FaqCategoryTable extends TableAbstract
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
     * FaqCategoryTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param FaqCategoryInterface $faqcategoryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, FaqCategoryInterface $faqcategoryRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $faqcategoryRepository;

        if (!Auth::user()->can(['faqcategory_edit', 'faqcategory_destroy'])) {
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
                if (! Auth::user()->can('faqcategory_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('faqcategory.edit', $item->id), DboardHelper::clean($item->name));
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
                return $item->status->toHtml();
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('faqcategory.edit', 'faqcategory.destroy', $item);
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
        return $this->addCreateButton(route('faqcategory.create'), 'faqcategory_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('faqcategory.deletes'), 'faqcategory_destroy', parent::bulkActions());
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
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
}
