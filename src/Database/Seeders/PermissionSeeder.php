<?php

namespace KrishnaWijaya\TiniPosReport\Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class PermissionSeeder extends Seeder
{
    public const PERMISSIONS = [
        'pembelian' => [
            'browse_pembelian',
            'create_pembelian',
            'read_pembelian',
        ],

        'persediaan' => [
            'browse_persediaan',
            'create_persediaan',
            'read_persediaan',
        ],

        'penjualan' => [
            'browse_penjualan',
            'create_penjualan',
            'read_penjualan',
        ],

        'stock_opname' => [
            'browse_stock_opname',
            'create_stock_opname',
            'read_stock_opname',
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
                Permission::firstOrCreate([
                    'key'        => $key,
                    'table_name' => $tableName,
                ]);
            }
        }
    }
}
