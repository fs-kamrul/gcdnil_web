<?php

namespace Modules\AdminBoard\Services\Abstracts;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminEvent;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;

abstract class StoreEventCategoryServiceAbstract
{
    public function __construct(AdminCategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, AdminEvent $event);
}
