<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Krishnawijaya\DodiUkirReport\Http\Controllers\Base\Controller as BaseController;

class Controller extends BaseController
{
    public $createView = "create";
    public $reportView = "report";
    public $detailsView = "details";
    public $viewBaseArguments = [];

    public function __construct(Model $model)
    {
        parent::__construct($model);

        $modelName = $this->getModelName();
        $modelIcon = $this->getModelIcon();

        $this->viewBaseArguments = compact("modelName", "modelIcon");
    }

    public function showDetails(Request $request, $id)
    {
        $isProhibited = Gate::denies("read_{$this->getModelName(true)}");
        if ($isProhibited) return abort(403);

        return view("dodiukirreport::$this->detailsView", $this->viewBaseArguments);
    }

    public function showReport(Request $request)
    {
        $modelAbility = $this->getModelName(true);
        $isProhibited = Gate::denies("browse_$modelAbility");

        if ($isProhibited) return abort(403);

        $this->viewBaseArguments["createAbility"] = Gate::allows("create_$modelAbility");
        $this->viewBaseArguments["readAbility"] = Gate::allows("read_$modelAbility");

        return view("dodiukirreport::$this->reportView", $this->viewBaseArguments);
    }

    public function create(Request $request)
    {
        $isProhibited = Gate::denies("create_{$this->getModelName(true)}");
        if ($isProhibited) return abort(403);

        $this->viewBaseArguments["roleName"] = Auth::user()->role->name;
        return view("dodiukirreport::$this->createView", $this->viewBaseArguments);
    }
}
