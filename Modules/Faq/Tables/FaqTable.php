<?php

namespace Modules\Faq\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Modules\Faq\Repositories\Interfaces\FaqInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class FaqTable extends TableAbstract
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
     * FaqTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param FaqInterface $faqRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, FaqInterface $faqRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $faqRepository;

        if (!Auth::user()->can(['faq_edit', 'faq_destroy'])) {
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
            ->editColumn('question', function ($item) {
                if (! Auth::user()->can('faq_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('faq.edit', $item->id), $item->question);
                }

                return $name;
            })
            ->editColumn('category_id', function ($item) {
                return $item->category->name;
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
                return $this->getOperations('faq.edit', 'faq.destroy', $item);
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
            'question',
            'created_at',
            'answer',
            'category_id',
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
            'question' => [
                'title' => trans('faq::faq.question'),
                'class' => 'text-start',
            ],
            'category_id' => [
                'title' => trans('faq::faq.category'),
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
        return $this->addCreateButton(route('faq.create'), 'faq_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('faq.deletes'), 'faq_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'question' => [
                'title' => trans('faq::faq.question'),
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
