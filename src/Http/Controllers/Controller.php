<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;

class Controller extends BaseController
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function queryBuilder()
    {
        return $this->model::query();
    }

    public function showBill(Request $request, $id)
    {
        $instance = $this->queryBuilder()->find($id);
        return ResponseFormatter::success($instance);
    }

    public function showReport(Request $request, $id)
    {
        $instance = $this->queryBuilder()->find($id);
        return ResponseFormatter::success($instance);
    }

    public function test()
    {
        return view('dodiukirreport::master');
    }
}
