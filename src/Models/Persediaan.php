<?php

namespace Krishnawijaya\DodiUkirReport\Models;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    public const ICON = "voyager-archive";

    protected $table = 'persediaan';
    protected $primaryKey = 'id_persediaan';
    protected $fillable = [
        'tanggal_persediaan',
        'total_persediaan',
        'total_harga_persediaan',
    ];
}
