<?php

namespace KrishnaWijaya\TiniPosReport\Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class RemovePermissionSeeder extends Seeder
{
    public const PERMISSIONS = [
        'pelanggan' => [
            'browse_pelanggan',
            'read_pelanggan',
            'edit_pelanggan',
            'add_pelanggan',
            'delete_pelanggan',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::PERMISSIONS as $tableName => $permissions) {
            foreach ($permissions as $key) {
                $permission = Permission::where('key', $key)->where('table_name', $tableName);
                if ($permission) $permission->forceDelete();
            }
        }
    }
}
