<?php

namespace Modules\KamrulDashboard\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\KamrulDashboard\Repositories\Interfaces\UserInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class UserTable extends TableAbstract
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
     * UserTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param UserInterface $userRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, UserInterface $userRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $userRepository;

        if (!Auth::user()->can(['user_edit', 'user_destroy'])) {
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
            ->editColumn('username', function ($item) {
                if (!Auth::user()->can('user_edit')) {
                    return $item->username;
                }

                return Html::link(route('user.pdf', $item->id), $item->username);
            })
            ->editColumn('name', function ($item) {
                if (! Auth::user()->can('user_edit')) {
                    $name = DboardHelper::clean($item->name);
                } else {
                    $name = Html::link(route('user.edit', $item->id), DboardHelper::clean($item->name));
                }

                return $name;
            })

            ->editColumn('role_id', function ($item) {
                if (!Auth::user()->can('user_edit')) {
                    return $item->role_id;
                }

                return view('kamruldashboard::user.partials.role', ['item' => $item])->render();
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
            ->addColumn('operations', function ($item) {
//                return $this->getOperations('user.edit', 'user.destroy', $item);
                $action = null;
                $action = Html::link(route('user.change_password', $item->id), trans('kamruldashboard::lang.change_password'),
                    ['class' => 'btn btn-info'])->toHtml();
                return apply_filters(KAMRULDASHBOARD_FILTER_USER_TABLE_ACTIONS,
                    $action . view('kamruldashboard::user.partials.actions', ['item' => $item])->render(), $item);
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
            'username',
            'email',
            'role_id',
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
            'username' => [
                'title' => trans('kamruldashboard::lang.username'),
                'class' => 'text-start',
            ],
            'email' => [
                'title' => trans('kamruldashboard::lang.email'),
                'class' => 'text-start',
            ],
            'role_id' => [
                'title' => trans('kamruldashboard::lang.role'),
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
        return $this->addCreateButton(route('user.create'), 'user_create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('user.deletes'), 'user_destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'username' => [
                'title' => trans('kamruldashboard::lang.username'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'email' => [
                'title' => trans('kamruldashboard::lang.email'),
                'type' => 'text',
                'validate' => 'required|max:120|email',
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
