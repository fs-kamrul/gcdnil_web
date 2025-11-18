<?php

namespace Modules\KamrulDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;

class BackupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name'         => "backup_access" ],
            [ 'name'         => "backup_create" ],
            [ 'name'         => "backup_restore" ],
            [ 'name'         => "backup_destroy" ],
        ];

        Permission::upsert($data, ['name']);
    }
}
