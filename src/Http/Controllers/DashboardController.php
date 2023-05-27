<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;
use Krishnawijaya\DodiUkirReport\Models\Pembelian;
use Krishnawijaya\DodiUkirReport\Models\Penjualan;

class DashboardController extends BaseController
{
    public function show(Request $request)
    {
        return view("dodiukirreport::dashboard");
    }

    public function getTopBarData(Request $request)
    {
        $totalPenjualanThisMonth = Penjualan::whereMonth('created_at', now()->format('m'))->sum('total_harga_jual');
        $totalPembelianThisMonth = Pembelian::whereMonth('created_at', now()->format('m'))->sum('total_harga_pembelian');

        $todayQuery = Penjualan::where('created_at', now());

        $revenue = $todayQuery->sum('total_harga_jual');
        $totalTransactions = $todayQuery->count();
        $profitLoss = $totalPenjualanThisMonth - $totalPembelianThisMonth;

        $response = [
            "revenue" => $revenue,
            "profit_and_loss" => $profitLoss,
            "total_transactions" => $totalTransactions,
        ];

        return ResponseFormatter::success($response);
    }

    public function getChartData(Request $request)
    {
        return ResponseFormatter::success();
    }
}
