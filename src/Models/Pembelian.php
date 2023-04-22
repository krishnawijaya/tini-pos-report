<?php

namespace Krishnawijaya\DodiUkirReport\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = [
        'tanggal_pembelian',
        'total_pembelian',
        'total_harga_pembelian',
    ];
}
