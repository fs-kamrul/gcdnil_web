<?php

namespace Modules\KamrulDashboard\Traits;

trait HasTreeCategory
{
    public static function updateTree(array $data): void
    {
        $tree = static::flatTree($data['data']);
        static::upsert($tree, ['id', 'name'], ['parent_id', 'order']);
    }

    protected static function flatTree(array $data, array &$tree = [], $parentId = 0): array
    {
//            dd($data);
        foreach ($data as $order=>$item) {

//            dd($order);
            $tree[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'order' => $order,
                'parent_id' => $parentId,
            ];

            if (! empty($item['children'])) {
                static::flatTree($item['children'], $tree, $item['id']);
            }
        }

        return $tree;
    }
}
