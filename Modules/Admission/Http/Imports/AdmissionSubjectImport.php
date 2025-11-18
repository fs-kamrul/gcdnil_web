<?php

namespace Modules\Admission\Http\Imports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Admission\Http\Models\AdmissionSubject;

class AdmissionSubjectImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AdmissionSubject([
            'uuid' => gen_uuid(),
            'name' => $row[0],
            'description' => $row[1],
            'status' => 1,
            'user_id' => Auth::id(),
        ]);
    }
}
