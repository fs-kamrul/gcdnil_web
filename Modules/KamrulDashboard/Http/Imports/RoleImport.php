<?php

namespace Modules\KamrulDashboard\Http\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Modules\KamrulDashboard\Http\Models\Role;

class RoleImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Role([
            'uuid' => gen_uuid(),
            'name' => $row[0],
            'description' => $row[1],
            'status' => 1,
        ]);
    }
}
