<?php

namespace Modules\KamrulDashboard\Tables;

use DboardHelper;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Modules\KamrulDashboard\Repositories\Interfaces\SettingrowInterface;
use Modules\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class SettingTable extends TableAbstract
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
     * SettingTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param SettingrowInterface $settingRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, SettingrowInterface $settingRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $settingRepository;

        if (!Auth::user()->can(['setting_edit', 'setting_destroy'])) {
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
            ->editColumn('title', function ($item) {
                if (! Auth::user()->can('setting_edit')) {
                    $name = DboardHelper::clean($item->title);
                } else {
                    $name = Html::link(route('settings.edit', $item->id), DboardHelper::clean($item->title));
                }

                return $name;
            })
            ->editColumn('created_at', function ($item) {
                return DboardHelper::formatDate($item->created_at);
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('settings.edit', 'settings.destroy', $item);
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
            'title',
            'key',
            'created_at',
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
            'title' => [
                'title' => trans('table::lang.name'),
                'class' => 'text-start',
            ],
            'key' => [
                'title' => trans('table::lang.key'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
        ];
    }

    public function buttons()
    {
        return $this->addCreateButton(route('settings.create'), 'setting_create');
    }

//    public function bulkActions(): array
//    {
//        return $this->addDeleteAction(route('settings.deletes'), 'setting_destroy', parent::bulkActions());
//    }

    public function getBulkChanges(): array
    {
        return [
            'title' => [
                'title' => trans('table::lang.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'created_at' => [
                'title' => trans('table::lang.created_at'),
                'type' => 'date',
            ],
        ];
    }
}
