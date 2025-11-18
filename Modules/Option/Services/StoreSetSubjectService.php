<?php

namespace Modules\Option\Services;

use Illuminate\Http\Request;
//use Modules\AdminBoard\Http\Models\AdminTeam;
//use Modules\AdminBoard\Services\Abstracts\StoreTeamCategoryServiceAbstract;
use Modules\Option\Http\Models\OptionSet;
use Modules\Option\Services\Abstracts\StoreSetSubjectServiceAbstract;

class StoreSetSubjectService extends StoreSetSubjectServiceAbstract
{
    public function execute(Request $request, OptionSet $project): void
    {
        $categories = $request->input('subjects', []);
        if (is_array($categories)) {
            if ($categories) {
                $project->subjects()->sync($categories);
            } else {
                $project->subjects()->detach();
            }
        }
    }
}
