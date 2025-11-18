<?php

namespace Modules\AdminBoard\Services;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminEvent;
use Modules\AdminBoard\Services\Abstracts\StoreEventCategoryServiceAbstract;

class StoreEventCategoryService extends StoreEventCategoryServiceAbstract
{
    public function execute(Request $request, AdminEvent $event): void
    {
        $categories = $request->input('categories', []);
        if (is_array($categories)) {
            if ($categories) {
                $event->categories()->sync($categories);
            } else {
                $event->categories()->detach();
            }
        }
    }
}
