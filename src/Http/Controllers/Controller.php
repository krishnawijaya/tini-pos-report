<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;

class Controller extends BaseController
{
    public function showBill(Request $request, $model)
    {
        return ResponseFormatter::success($model);
    }

    public function showReport(Request $request, $model)
    {
        return ResponseFormatter::success($model);
    }
}
