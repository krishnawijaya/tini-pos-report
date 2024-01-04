<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Base;

use Illuminate\Database\Eloquent\Model;
use KrishnaWijaya\TiniPosReport\Helpers\Str;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModelName($forceLowerCase = false, $abbreviation = false, $separator = "-")
    {
        $modelName = class_basename($this->model);
        $modelName = Str::fromCamelorPascalCase($modelName, $separator);

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
