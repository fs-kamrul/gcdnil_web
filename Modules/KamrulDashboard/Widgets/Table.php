<?php

namespace Modules\KamrulDashboard\Widgets;


use Modules\Table\Supports\TableBuilder;

abstract class Table extends Widget
{
    protected $view = 'table';

    protected $id;

    protected $route;

    protected $builder;

    protected $params = [];

    protected $table;

    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
        parent::__construct();
    }

    public function route(string $route, array $params = [])
    {
        $this->route = $route;
        $this->params = $params;

        return $this;
    }

    public function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'table' => $this->builder
                ->create($this->table)
                ->setAjaxUrl(route($this->route, $this->params))
                ->renderTable(),
        ]);
    }

    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }
}
