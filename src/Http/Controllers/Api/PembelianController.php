<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use KrishnaWijaya\TiniPosReport\Models\Pembelian;

class PembelianController extends Controller
{
    public function __construct(Pembelian $model)
    {
        parent::__construct($model);
    }
}
