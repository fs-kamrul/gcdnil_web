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

class AdmissionTable extends TableAbstract
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
                if (! Auth::user()->can('admission_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('admission.edit', $item->id), DboardHelper::clean($item->name));
                }

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
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) use ($statusDesign) {
                return Arr::get($statusDesign, $item->status , __('In active'));
            })
            ->editColumn('payment_status', function ($item) use ($paymentStatusDesign) {
                return Arr::get($paymentStatusDesign, $item->payment_status , __('Due'));
            })
            ->addColumn('operations', function ($item) {
                return view('admission::partials.admission_actions', compact('item'))->render();
//                return $this->getOperations('admission.edit', 'admission.destroy', $item);
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
            'uuid',
            'name',
            'photo',
            'student_id',
            'payment_amount',
            'payment_status',
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
            'photo'      => [
                'title' => trans('table::lang.image'),
                'width' => '70px',
            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'student_id' => [
                'title' => trans('admission::lang.student_id'),
                'class' => 'text-start',
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
        return $this->addCreateButton(route('admission.create'), 'admission_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('admission.deletes'), 'admission_destroy', parent::bulkActions());
    }

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
