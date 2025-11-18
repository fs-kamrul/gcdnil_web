<?php

namespace Modules\KamrulDashboard\Packages\Supports;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SortItemsWithChildrenHelper
{
    protected $items;

    protected $parentField = 'parent_id';

    protected $compareKey = 'id';

    protected $childrenProperty = 'children_items';

    protected $result = [];

    public function setItems($items): self
    {
        if (! $items instanceof Collection) {
            $items = collect($items);
        }

        $this->items = $items;

        return $this;
    }

    public function setParentField(string $string): self
    {
        $this->parentField = $string;

        return $this;
    }

    public function setCompareKey(string $key): self
    {
        $this->compareKey = $key;

        return $this;
    }

    public function setChildrenProperty(string $string): self
    {
        $this->childrenProperty = $string;

        return $this;
    }

    public function sort(): array
    {
        return $this->processSort();
    }

    protected function processSort(int $parentId = 0): array
    {
        $result = [];
        $filtered = $this->items->where($this->parentField, $parentId);
        foreach ($filtered as $item) {
            if (is_object($item)) {
                $item->{$this->childrenProperty} = $this->processSort($item->{$this->compareKey});
            } else {
                $item[$this->childrenProperty] = $this->processSort(Arr::get($item, $this->compareKey));
            }
            $result[] = $item;
        }

        return $result;
    }
}
