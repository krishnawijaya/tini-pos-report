<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;

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

    public function showBill(Request $request, $id)
    {
        $modelName = $this->getModelName();
        $modelIcon = $this->getModelIcon();

        return view("dodiukirreport::bill", compact("modelName", "modelIcon"));
    }

    public function showReport(Request $request)
    {
        $modelName = $this->getModelName();
        $modelIcon = $this->getModelIcon();

        return view("dodiukirreport::report", compact("modelName", "modelIcon"));
    }

    public function create(Request $request)
    {
        $modelName = $this->getModelName();
        $modelIcon = $this->getModelIcon();

        return view("dodiukirreport::create", compact("modelName", "modelIcon"));
    }
}
