<?php

namespace KrishnaWijaya\TiniPosReport\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    public const ICON = "voyager-logbook";
    protected $table = 'stock_opname';

    protected $fillable = [
        'tanggal',
        'total_tercatat',
        'total_harga_tercatat',
        'total_nyata',
        'total_harga_nyata',
    ];

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'detail_stock_opname', 'id_stock_opname', 'id_barang', 'id', 'id_barang')
            ->withPivot('jumlah_tercatat', 'jumlah_nyata', 'harga', 'alasan');
    }
}
