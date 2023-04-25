<?php

namespace Krishnawijaya\DodiUkirReport\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    public const ICON = "voyager-dollar";

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = [
        'id_user',
        'id_pelanggan',
        'tanggal_jual',
        'total_jual',
        'total_harga_jual',

    ];
}
