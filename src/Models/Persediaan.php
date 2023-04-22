<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    protected $table = 'persediaan';
    protected $primaryKey = 'id_persediaan';
    protected $fillable = [
        'tanggal_persediaan',
        'total_persediaan',
        'total_harga_persediaan',
    ];
}
