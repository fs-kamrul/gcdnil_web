<?php

namespace Modules\AdminBoard\Services;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminNews;
use Modules\AdminBoard\Services\Abstracts\StoreNewsCategoryServiceAbstract;

class StoreNewsCategoryService extends StoreNewsCategoryServiceAbstract
{
    public function execute(Request $request, AdminNews $adminNews): void
    {
        $categories = $request->input('categories', []);
        if (is_array($categories)) {
            if ($categories) {
                $adminNews->categories()->sync($categories);
            } else {
                $adminNews->categories()->detach();
            }
        }
    }
}
