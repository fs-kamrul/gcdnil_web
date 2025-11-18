<?php

namespace Modules\AdminBoard\Services;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminNoticeBoard;
use Modules\AdminBoard\Services\Abstracts\StoreNoticeBoardCategoryServiceAbstract;

class StoreNoticeBoardCategoryService extends StoreNoticeBoardCategoryServiceAbstract
{
    public function execute(Request $request, AdminNoticeBoard $noticeboard): void
    {
        $categories = $request->input('categories', []);
        if (is_array($categories)) {
            if ($categories) {
                $noticeboard->categories()->sync($categories);
            } else {
                $noticeboard->categories()->detach();
            }
        }
    }
}
