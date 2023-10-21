<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Http\Controllers\VoyagerController as BaseVoyagerController;

class VoyagerController extends BaseVoyagerController
{
    public function index()
    {
        if (Auth::user()->isKasir()) {
            return redirect()->route('tiniposreport.penjualan.create');

        } else {
            return redirect()->route('tiniposreport.dashboard');
        }
    }
}
