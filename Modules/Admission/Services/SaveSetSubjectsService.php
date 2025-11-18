<?php

namespace Modules\Admission\Services;

use Illuminate\Support\Facades\DB;
use Modules\Admission\Http\Models\Admission;


// adjust namespace to your model

class SaveSetSubjectsService
{
    public function execute(Admission $admission, array $subjectData): void
    {
        if (empty($subjectData) || !is_array($subjectData)) {
            return;
        }

        // Remove old records for this admission
        DB::table('admission_set_subjects')
            ->where('admission_id', $admission->id)
            ->delete();

        $insertData = [];

        foreach ($subjectData as $setId => $subjectIds) {
            if (!is_array($subjectIds)) {
                continue;
            }

            foreach ($subjectIds as $subjectId) {
                $insertData[] = [
                    'admission_id' => $admission->id,
                    'set_id' => (int)$setId,
                    'subject_id' => (int)$subjectId,
                ];
            }
        }

        if (!empty($insertData)) {
            DB::table('admission_set_subjects')->insert($insertData);
        }
    }
}
