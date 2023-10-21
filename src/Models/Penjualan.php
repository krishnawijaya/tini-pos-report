<?php

namespace KrishnaWijaya\TiniPosReport\Models;

use App\Models\User;
use App\Models\Barang;
use App\Models\Pelanggan;
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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'detail_penjualan', 'id_penjualan', 'id_barang', 'id_penjualan', 'id_barang')
            ->withPivot('jumlah', 'harga');
    }
}
