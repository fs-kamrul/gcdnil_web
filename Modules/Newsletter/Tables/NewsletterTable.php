<?php

namespace Modules\Newsletter\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Ecommerce\Repositories\Interfaces\EcommerceProductInterface;
use Modules\Newsletter\Http\packages\NewsletterStatus;
use Modules\Newsletter\Repositories\Interfaces\NewsletterInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class NewsletterTable extends TableAbstract
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
     * NewsletterTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param NewsletterInterface $newsletterRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, NewsletterInterface $newsletterRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $newsletterRepository;

        if (!Auth::user()->can(['newsletter_edit', 'newsletter_destroy'])) {
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
                if (! Auth::user()->can('newsletter_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    if($item->name) {
                        $name = Html::link(route('newsletter.edit', $item->id), DboardHelper::clean($item->name));
                    }else{
                        $name ='&mdash;';
                    }
                }

                return $name;
            })
            ->editColumn('product_id', function ($item) {
                return $item->product_name;
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
                return $item->status->toHtml();
//                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('newsletter.edit', 'newsletter.destroy', $item);
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
            'email',
            'name',
            'product_id',
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
            'email' => [
                'title' => trans('table::lang.email'),
                'class' => 'text-start',
            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'product_id' => [
                'title' => trans('ecommerce::products.name'),
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
        return $this->addCreateButton(route('newsletter.create'), 'newsletter_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('newsletter.deletes'), 'newsletter_destroy', parent::bulkActions());
    }

    public function getProducts($value = null): array
    {
        $categorySelected = [];
        if ($value) {
            $product = app(EcommerceProductInterface::class)->findById($value);
            if ($product) {
                $categorySelected = [$product->id => $product->name];
            }
        }

        return [
            'url' => route('ecommerceproduct.search'),
            'selected' => $categorySelected,
        ];
    }
    public function getBulkChanges(): array
    {
        return [
            'email' => [
                'title' => trans('table::lang.email'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'product_id' => [
                'title' => trans('ecommerce::products.name'),
                'type' => 'select-ajax',
                'validate' => 'required',
                'callback' => 'getProducts',
            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'type' => 'customSelect',
                'choices' => NewsletterStatus::labels(),
                'validate' => 'required|' . Rule::in(NewsletterStatus::values()),
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
