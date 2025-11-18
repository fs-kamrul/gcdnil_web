<?php

namespace Modules\Post\Http\Imports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Post\Http\Models\Page;

class PageImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Page([
            'uuid' => gen_uuid(),
            'name' => $row[0],
            'slug' => createSlugFunction($row[0],'Modules\Post\Http\Models\Page'),
            'description' => $row[1],
            'status' => 1,
            'user_id' => Auth::id(),
        ]);
    }
}
