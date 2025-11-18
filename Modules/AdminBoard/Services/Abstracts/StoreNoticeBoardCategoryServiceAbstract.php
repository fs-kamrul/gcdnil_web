<?php

namespace Modules\AdminBoard\Services\Abstracts;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminNoticeBoard;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;

abstract class StoreNoticeBoardCategoryServiceAbstract
{
    public function __construct(AdminCategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, AdminNoticeBoard $noticeboard);
}
