<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Krishnawijaya\DodiUkirReport\Models\Penjualan;

class PenjualanController extends Controller
{
    public function __construct(Penjualan $model)
    {
        parent::__construct($model);
    }
}
