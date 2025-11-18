<?php

namespace Modules\AdminBoard\Services\Abstracts;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;

abstract class StoreTeamCategoryServiceAbstract
{
    public function __construct(AdminCategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, AdminTeam $project);
}
