<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use KrishnaWijaya\TiniPosReport\Models\Pembelian;
use KrishnaWijaya\TiniPosReport\Models\Penjualan;
use Illuminate\Routing\Controller as BaseController;
use KrishnaWijaya\TiniPosReport\Helpers\ResponseFormatter;

class DashboardController extends BaseController
{
    public function show(Request $request)
    {
        return view("tiniposreport::dashboard");
    }

    public function getTopBarData(Request $request)
    {
        $totalPenjualanThisMonth = Penjualan::whereMonth('created_at', now()->format('m'))->sum('total_harga_jual');
        $totalPembelianThisMonth = Pembelian::whereMonth('created_at', now()->format('m'))->sum('total_harga_pembelian');

        $todayQuery = Penjualan::whereDate('created_at', now());

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
        $response = [];
        $endDate = now()->endOfMonth();
        $startDate = $endDate->copy()->subMonths(11)->startOfMonth();

        $penjualan = Penjualan::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'ASC')->get();

        $penjualan->each(function ($penjualan) use (&$response) {
            $monthName = Carbon::parse($penjualan->created_at)->format('F');

            if (!isset($response[$monthName])) $response[$monthName] = $penjualan->total_harga_jual;
            else  $response[$monthName] += $penjualan->total_harga_jual;
        });

        return ResponseFormatter::success($response);
    }
}
