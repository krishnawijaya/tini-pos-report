<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

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
