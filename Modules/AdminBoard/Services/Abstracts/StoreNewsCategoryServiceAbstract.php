<?php

namespace Modules\AdminBoard\Services\Abstracts;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminNews;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;

abstract class StoreNewsCategoryServiceAbstract
{
    public function __construct(AdminCategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, AdminNews $project);
}
