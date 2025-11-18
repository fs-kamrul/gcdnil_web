<?php

namespace Modules\Option\Services\Abstracts;

use Illuminate\Http\Request;
use Modules\Option\Http\Models\OptionSet;
use Modules\Option\Repositories\Interfaces\OptionSubjectInterface;

abstract class StoreSetSubjectServiceAbstract
{
    public function __construct(OptionSubjectInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, OptionSet $project);
}
