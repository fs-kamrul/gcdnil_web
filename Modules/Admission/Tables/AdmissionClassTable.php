<?php

namespace Modules\Admission\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class AdmissionClassTable extends TableAbstract
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
     * OptionClassTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param OptionClassInterface $optionclassRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, OptionClassInterface $optionclassRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $optionclassRepository;

        if (!Auth::user()->can(['optionclass_edit', 'optionclass_destroy'])) {
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
                if (! Auth::user()->can('optionclass_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('optionclass.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
            ->editColumn('photo', function ($item) {
                $photo_path = 'optionclass';
                $photo = getImageUrl($item->photo,$photo_path);
                return $this->displayThumbnail(url($photo));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->addColumn('operations', function ($item) {
                return view('admission::partials.actions', compact('item'))->render();
//                return $this->getOperations('optionclass.edit', 'optionclass.destroy', $item);
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
            'photo',
            'order',
            'created_at',
            'user_id',
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
        ];
    }

    public function buttons()
    {
//        return $this->addCreateButton(route('optionclass.create'), 'optionclass_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('optionclass.deletes'), 'optionclass_destroy', parent::bulkActions());
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
