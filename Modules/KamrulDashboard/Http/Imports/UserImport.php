<?php

namespace Modules\KamrulDashboard\Http\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Modules\KamrulDashboard\Http\Models\User;

class UserImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'uuid' => gen_uuid(),
            'name' => $row[0],
            'description' => $row[1],
            'status' => 1,
        ]);
    }
}
