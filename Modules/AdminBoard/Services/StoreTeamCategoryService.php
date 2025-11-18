<?php

namespace Modules\AdminBoard\Services;

use Illuminate\Http\Request;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\AdminBoard\Services\Abstracts\StoreTeamCategoryServiceAbstract;

class StoreTeamCategoryService extends StoreTeamCategoryServiceAbstract
{
    public function execute(Request $request, AdminTeam $project): void
    {
        $categories = $request->input('categories', []);
        if (is_array($categories)) {
            if ($categories) {
                $project->categories()->sync($categories);
            } else {
                $project->categories()->detach();
            }
        }
    }
}
