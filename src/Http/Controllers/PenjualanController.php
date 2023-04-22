<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Support\Facades\Request;

class PenjualanController extends Controller
{
    public function __construct(Penjualan $model)
    {
        parent::__construct($model);
    }
}
