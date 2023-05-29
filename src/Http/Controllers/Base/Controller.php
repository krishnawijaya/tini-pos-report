<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModelName($forceLowerCase = false, $abbreviation = false)
    {
        $modelName = class_basename($this->model);

        if ($forceLowerCase) $modelName = strtolower($modelName);
        if ($abbreviation && strtolower($modelName) == "penjualan") $modelName = "jual";

        return $modelName;
    }

    public function getModelIcon()
    {
        return $this->model::ICON;
    }

    public function queryBuilder()
    {
        return $this->model::query();
    }
}
