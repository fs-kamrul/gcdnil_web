<?php

namespace Modules\Admission\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;
use Admissionoption;

class AdmissionClassStudentTable extends TableAbstract
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
     * AdmissionTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param AdmissionInterface $admissionRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, AdmissionInterface $admissionRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $admissionRepository;

        if (!Auth::user()->can(['admission_edit', 'admission_destroy'])) {
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
        $paymentStatusDesign = get_payment_status_design();

        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
//                if (! Auth::user()->can('admission_edit')) {
                    $name = DboardHelper::clean($item->name);
//                } else {
//                    $name = Html::link(route('admission.edit', $item->id), DboardHelper::clean($item->name));
//                }

                return $name;
            })
            ->editColumn('photo', function ($item) {
                $photo_path = 'admission';
                $photo = getImageUrl($item->photo,$photo_path);
                return $this->displayThumbnail(url($photo));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('roll', function ($item) {
                return view('admission::admission.partials.roll', compact('item'))->render();
            })
            ->editColumn('admission_merits_id', function ($item) {
                return $item->admission_merits_id ? Admissionoption::getMeritNameById($item->admission_merits_id) : '&mdash;';
            })
            ->editColumn('mark', function ($item) {
//                return formatNumber($item->averageMark());
                return $item->mark;
            })
            ->editColumn('payment_status', function ($item) use ($paymentStatusDesign) {
                return Arr::get($paymentStatusDesign, $item->payment_status , __('Due'));
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->addColumn('operations', function ($item) {
                return view('admission::admission.partials.actions', compact('item'))->render();
//                return $this->getOperations('admission.edit', 'admission.destroy', $item);
            });

        return $this->toJson($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $class_id = Arr::get($this->options, 'class_id');
        $year_id = Arr::get($this->options, 'year_id');
        $query = $this->repository->getModel()->select([
            'id',
            'uuid',
            'name',
            'father_name',
            'mother_nane',
            'roll',
            'payment_amount',
            'payment_status',
            'photo',
            'admission_merits_id',
            'mark',
            'created_at',
            'updated_at',
            'status',
        ]);
        if (!is_null($class_id)) {
            $query->where('class', $class_id); // Apply the post_id filter
        }
        if (!is_null($year_id)) {
            $query->where('year', $year_id); // Apply the post_id filter
        }
        return $this->applyScopes($query);
    }

    public function htmlDrawCallbackFunction(): ?string
    {
        return parent::htmlDrawCallbackFunction() . '$(".editable").editable({mode: "inline"});';
    }
    public function columns()
    {
        return [
            'id' => [
                'title' => trans('table::lang.id'),
                'width' => '20px',
            ],
            'photo'      => [
                'title' => trans('table::lang.image'),
                'width' => '70px',
            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'roll' => [
                'title' => trans('table::lang.roll'),
                'class' => 'text-start',
            ],
            'father_name' => [
                'title' => trans('table::lang.father_name'),
                'class' => 'text-start',
            ],
            'mother_nane' => [
                'title' => trans('table::lang.mother_nane'),
                'class' => 'text-start',
            ],
            'mark' => [
                'title' => trans('table::lang.mark'),
                'width' => '100px',
                'class' => 'text-center',
                'orderable' => true,
            ],
            'payment_amount' => [
                'title' => trans('admission::lang.payment_amount'),
                'class' => 'text-start',
            ],
            'payment_status' => [
                'title' => trans('admission::lang.payment_status'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            'admission_merits_id' => [
                'title' => trans('admission::lang.admissionmerit'),
                'width' => '100px',
                'class' => 'text-center',
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
        $class_id = Arr::get($this->options, 'class_id');
        $year_id = Arr::get($this->options, 'year_id');
//        return $this->addCreateButton(route('admission.create'), 'admission_create');
        $buttons = [];
        if (Auth::user()->can('admission_access')) {
            $buttons['create'] = [
                'extend' => 'collection',
                'text' => view('table::partials.report')->render(),
                'buttons' => [
                    [
                        'className' => 'action-item',
                        'text' => Html::tag('i', '', [
                                'class' => 'icon-settings text-primary',
                                'title' => __('admission::lang.site_plan'),
                            ])->toHtml() . ' ' . Html::tag('span', __('admission::lang.site_plan'), [
                                'data-action' => 'site-plan',
                                'data-href' => route('site_plan', [$class_id, $year_id]),
//                                'target' => "_blank",
                                'class' => 'ml-1 color-black',
                            ])->toHtml(),
                    ],
                    [
                        'className' => 'action-item',
//                        'text' => ProductType::DIGITAL()->toIcon() . ' ' . Html::tag('span', ProductType::DIGITAL()->label(), [
                        'text' => Html::tag('i', '', [
                                'class' => 'icon-download1 text-primary',
                                'title' => __('admission::lang.add_mark'),
                            ])->toHtml() . ' ' . Html::tag('span', __('admission::lang.add_mark'), [
                                'data-action' => 'digital-product',
                                'data-href' => route('admissionmark.mark', [$class_id, $year_id]),
                                'class' => 'ml-1 color-black',
                            ])->toHtml(),
                    ],
                    [
                        'className' => 'action-item',
//                        'text' => ProductType::DIGITAL()->toIcon() . ' ' . Html::tag('span', ProductType::DIGITAL()->label(), [
                        'text' => Html::tag('i', '', [
                                'class' => 'icon-printer2 text-primary',
                                'title' =>  __('admission::lang.merit_result'),
                            ])->toHtml() . ' ' . Html::tag('span', __('admission::lang.merit_result'), [
                                'data-action' => 'digital-product',
                                'data-href' => route('merit_result', [$class_id, $year_id]),
                                'class' => 'ml-1 color-black',
                            ])->toHtml(),
                    ],
                    [
                        'className' => 'action-item',
//                        'text' => ProductType::DIGITAL()->toIcon() . ' ' . Html::tag('span', ProductType::DIGITAL()->label(), [
                        'text' => Html::tag('i', '', [
                                'class' => 'icon-upload text-primary',
                                'title' => __('admission::lang.student_migration'),
                            ])->toHtml() . ' ' . Html::tag('span', __('admission::lang.student_migration'), [
                                'data-action' => 'digital-product',
                                'data-href' => route('admissionmigration', [$class_id, $year_id]),
                                'class' => 'ml-1 color-black',
                            ])->toHtml(),
                    ],
                ],
            ];
        }
//        else {
//            $buttons = $this->addCreateButton(route('ecommerceproduct.create', ['product_type' => 'digital']), 'ecommerceproduct_create');
//        }
        return $buttons;
    }

//    public function bulkActions(): array
//    {
//        return $this->addDeleteAction(route('admission.deletes'), 'admission_destroy', parent::bulkActions());
//    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'payment_status' => [
                'title' => trans('admission::lang.payment_status'),
                'type' => 'customSelect',
                'choices' => payment_design_status(),
                'validate' => 'required',
            ],
            'payment_amount' => [
                'title' => trans('admission::lang.payment_amount'),
                'type' => 'text',
                'validate' => 'required',
            ],
            'status' => [
                'title' => trans('table::lang.status'),
                'type' => 'customSelect',
                'choices' => array_status(),
                'validate' => 'required',
            ],
            'admission_merits_id' => [
                'title' => trans('admission::lang.admissionmerit'),
                'type' => 'customSelect',
                'choices' => Admissionoption::getMerit(),
                'validate' => 'required',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
