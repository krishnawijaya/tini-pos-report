<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerController as BaseVoyagerController;

class VoyagerController extends BaseVoyagerController
{
    public function index()
    {
        if (Auth::user()->isKasir()) {
            return redirect()->route('dodiukirreport.penjualan.create');

        } else {
            return redirect()->route('dodiukirreport.dashboard');
        }
    }
}
