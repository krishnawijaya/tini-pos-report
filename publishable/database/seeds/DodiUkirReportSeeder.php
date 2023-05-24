<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class DodiUkirReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = [
            'browse_pembelian',
            'browse_persediaan',
            'browse_penjualan',

            'create_pembelian',
            'create_persediaan',
            'create_penjualan',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }
    }
}
