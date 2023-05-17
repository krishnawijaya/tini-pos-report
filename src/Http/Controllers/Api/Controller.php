<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;

class Controller extends BaseController
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModelName()
    {
        return class_basename($this->model);
    }

    public function getModelIcon()
    {
        return $this->model::ICON;
    }

    public function queryBuilder()
    {
        return $this->model::query();
    }

    public function index(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = $this->queryBuilder();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [new Carbon($startDate), new Carbon($endDate)]);
        }
        $data = $query->get();

        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->findOrFail($id);

        return ResponseFormatter::success($data);
    }

    public function create(Request $request)
    {
        $data = $this->queryBuilder()->create($request);

        return ResponseFormatter::success($data);
    }
}
