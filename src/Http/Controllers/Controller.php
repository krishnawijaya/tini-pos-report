<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use KrishnaWijaya\TiniPosReport\Http\Controllers\Base\Controller as BaseController;

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
        $modelAbility = $this->getModelName(true, false, '_');
        $isProhibited = Gate::denies("read_{$modelAbility}");
        if ($isProhibited) return abort(403);

        return view("tiniposreport::$this->detailsView", $this->viewBaseArguments);
    }

    public function showReport(Request $request)
    {
        $modelAbility = $this->getModelName(true, false, '_');
        $isProhibited = Gate::denies("browse_$modelAbility");

        if ($isProhibited) return abort(403);

        $this->viewBaseArguments["createAbility"] = Gate::allows("create_$modelAbility") && $modelAbility != "persediaan";
        $this->viewBaseArguments["readAbility"] = Gate::allows("read_$modelAbility");
        $this->viewBaseArguments["editAbility"] = Gate::allows("edit_$modelAbility");

        return view("tiniposreport::$this->reportView", $this->viewBaseArguments);
    }

    public function create(Request $request)
    {
        $modelAbility = $this->getModelName(true, false, '_');
        $isProhibited = Gate::denies("create_$modelAbility");
        if ($isProhibited) return abort(403);

        $this->viewBaseArguments["roleName"] = Auth::user()->role->name;
        return view("tiniposreport::$this->createView", $this->viewBaseArguments);
    }
}
