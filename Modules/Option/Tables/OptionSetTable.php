<?php

namespace Modules\Option\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Option\Enums\OptionSetStatusEnum;
use Modules\Option\Repositories\Interfaces\OptionSetInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;
use Option;

class OptionSetTable extends TableAbstract
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
     * OptionSetTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param OptionSetInterface $optionsetRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, OptionSetInterface $optionsetRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $optionsetRepository;

        if (!Auth::user()->can(['optionset_edit', 'optionset_destroy'])) {
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
            ->editColumn('name', function ($item) {
                if (! Auth::user()->can('optionset_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('optionset.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })
//            ->editColumn('photo', function ($item) {
//                $photo_path = 'option/optionset';
//                $photo = getImageUrl($item->photo,$photo_path);
//                return $this->displayThumbnail(url($photo));
//            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('class_id', function ($item) {
                return Option::getClassNameById($item->class_id);
            })
            ->editColumn('group_id', function ($item) {
                return Option::getGroupNameById($item->group_id);
            })
            ->editColumn('updated_at', function ($item) {
                $subjects = '';
                foreach ($item->subjects as $subject) {
//                    $subjects .= Html::link(route('category.edit', $category->id), $category->name) . ', ';
                    $subjects .= $subject->name . ', ';
                }

                return rtrim($subjects, ', ');
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->editColumn('user_id', function ($item) {
                return $item->user && $item->user->name ? clean($item->user->name) : '&mdash;';
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('optionset.edit', 'optionset.destroy', $item);
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
            'class_id',
            'group_id',
//            'subject_id',
            'updated_at',
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
//            'photo'      => [
//                'title' => trans('table::lang.image'),
//                'width' => '70px',
//            ],
            'name' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'class_id' => [
                'title' => trans('table::lang.class'),
                'class' => 'text-start',
            ],
            'group_id' => [
                'title' => trans('option::lang.group'),
                'class' => 'text-start',
            ],
            'updated_at' => [
                'title' => trans('option::lang.subject'),
                'class' => 'text-start',
            ],
            'order' => [
                'title' => trans('table::lang.order'),
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
            'user_id'  => [
                'title'     => trans('table::lang.author'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
        ];
    }

    public function buttons()
    {
        return $this->addCreateButton(route('optionset.create'), 'optionset_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('optionset.deletes'), 'optionset_destroy', parent::bulkActions());
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
                'choices' => OptionSetStatusEnum::labels(),
                'validate' => 'required',
            ],
            'class_id' => [
                'title' => trans('table::lang.class'),
                'type' => 'customSelect',
                'choices' => Option::getClass(),
                'validate' => 'required',
            ],
            'group_id' => [
                'title' => trans('option::lang.group'),
                'type' => 'customSelect',
                'choices' => Option::getGroup(),
                'validate' => 'required',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
}
