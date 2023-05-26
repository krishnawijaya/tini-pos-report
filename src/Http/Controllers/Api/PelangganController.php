<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use App\Models\Pelanggan;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;

class PelangganController extends Controller
{
    public function __construct(Pelanggan $model)
    {
        parent::__construct($model);
    }
}
