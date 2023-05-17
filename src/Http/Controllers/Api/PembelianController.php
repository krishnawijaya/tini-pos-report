<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use Krishnawijaya\DodiUkirReport\Models\Pembelian;

class PembelianController extends Controller
{
    public function __construct(Pembelian $model)
    {
        parent::__construct($model);
    }
}
