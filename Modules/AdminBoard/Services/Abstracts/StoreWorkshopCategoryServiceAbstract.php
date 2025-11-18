<?php

namespace Modules\AdminBoard\Services\Abstracts;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;

abstract class StoreWorkshopCategoryServiceAbstract
{
    public function __construct(AdminCategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, AdminWorkshop $workshop);
}
