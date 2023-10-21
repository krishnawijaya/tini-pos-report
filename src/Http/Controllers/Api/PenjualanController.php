<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use KrishnaWijaya\TiniPosReport\Models\Penjualan;

class PenjualanController extends Controller
{
    public function __construct(Penjualan $model)
    {
        parent::__construct($model);
    }
}
