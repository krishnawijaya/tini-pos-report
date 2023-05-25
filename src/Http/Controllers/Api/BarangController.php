<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use App\Models\Barang;

class BarangController extends Controller
{
    public function __construct(Barang $model)
    {
        parent::__construct($model);
    }
}
