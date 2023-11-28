<?php

namespace KrishnaWijaya\TiniPosReport\Models;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    public const ICON = "voyager-book";

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_supplier',
        'tanggal_pembelian',
        'total_pembelian',
        'total_harga_pembelian',
    ];

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'detail_pembelian', 'id_pembelian', 'id_barang', 'id_pembelian', 'id_barang')
            ->withPivot('jumlah', 'harga');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
}
