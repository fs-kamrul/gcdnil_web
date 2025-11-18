<?php

namespace Modules\AdminBoard\Services;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Modules\AdminBoard\Services\Abstracts\StoreWorkshopCategoryServiceAbstract;

class StoreWorkshopCategoryService extends StoreWorkshopCategoryServiceAbstract
{
    public function execute(Request $request, AdminWorkshop $workshop): void
    {
        $categories = $request->input('categories', []);
        if (is_array($categories)) {
            if ($categories) {
                $workshop->categories()->sync($categories);
            } else {
                $workshop->categories()->detach();
            }
        }
    }
}
