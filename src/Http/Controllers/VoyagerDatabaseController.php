<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerDatabaseController as BaseVoyagerDatabaseController;

class VoyagerDatabaseController extends BaseVoyagerDatabaseController
{
    public function store(Request $request)
    {
        $request->request->add(["create_migration" => "on"]);
        return parent::store($request);
    }
}
