<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;

class DashboardController extends BaseController
{
    public function show(Request $request)
    {
        return view("dodiukirreport::dashboard");
    }
}
