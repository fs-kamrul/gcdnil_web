<?php

namespace Modules\AdminBoard\Services;

use Modules\AdminBoard\Http\Models\AdminTeam;

class SaveEducationsService
{
    public function execute(AdminTeam $item, $educations): void
    {
        if (! $educations || ! is_array($educations)) {
            return;
        }

        $educationsToSync = [];

        $item->admin_educations()->detach();

        foreach ($educations as $education) {
            if (empty($education['id']) || $education['id'] == '0') {
                continue;
            }
//            dd($education);

            $educationsToSync[$education['id']] = [
                'name_title' => $education['name_title'],
            ];
        }

        if (empty($educationsToSync)) {
            return;
        }

        $item->admin_educations()->syncWithoutDetaching($educationsToSync);
    }
}
