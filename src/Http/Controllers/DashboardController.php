<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use KrishnaWijaya\TiniPosReport\Models\Pembelian;
use KrishnaWijaya\TiniPosReport\Models\Penjualan;
use KrishnaWijaya\TiniPosReport\Models\Penyesuaian;
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
        $reportType = $request->input("report_type", "bulanan");

        $totalPenyesuaianQuery = Penyesuaian::whereYear('created_at', Carbon::now()->year);
        $totalPenjualanQuery = Penjualan::whereYear('created_at', Carbon::now()->year);
        $totalPembelianQuery = Pembelian::whereYear('created_at', Carbon::now()->year);
        $todayQuery = Penjualan::whereYear('created_at', Carbon::now()->year);

        if (in_array($reportType, ["bulanan", "harian"])) {
            $totalPenyesuaianQuery->whereMonth('created_at', Carbon::now()->month);
            $totalPenjualanQuery->whereMonth('created_at', Carbon::now()->month);
            $totalPembelianQuery->whereMonth('created_at', Carbon::now()->month);
            $todayQuery->whereMonth('created_at', Carbon::now()->month);

            if ($reportType == "harian") {
                $totalPenyesuaianQuery->whereDay('created_at', Carbon::now()->day);
                $totalPenjualanQuery->whereDay('created_at', Carbon::now()->day);
                $totalPembelianQuery->whereDay('created_at', Carbon::now()->day);
                $todayQuery->whereDay('created_at', Carbon::now()->day);
            }
        }

        $totalPenyesuaian = $totalPenyesuaianQuery->sum('nilai');
        $totalPenjualan = $totalPenjualanQuery->sum('total_harga_jual');
        $totalPembelian = $totalPembelianQuery->sum('total_harga_pembelian');

        $revenue = $todayQuery->sum('total_harga_jual');
        $totalTransactions = $todayQuery->count();
        $profitLoss = ($totalPenjualan - $totalPembelian) + $totalPenyesuaian;

        $response = [
            "revenue" => $revenue,
            "profit_and_loss" => $profitLoss,
            "total_transactions" => $totalTransactions,
        ];

        return ResponseFormatter::success($response);
    }

    public function getChartData(Request $request)
    {
        $reportType = $request->input("report_type", "bulanan");
        $response = [];

        $endDate = Carbon::now()->endOfMonth();
        $startDate = $endDate->copy()->subMonths(11)->startOfMonth();

        if ($reportType == "tahunan") {
            $endDate = Carbon::now()->endOfYear();
            $startDate = $endDate->copy()->subYears(5)->startOfYear();
        } elseif ($reportType == "harian") {

            $endDate = Carbon::now()->endOfDay();
            $startDate = $endDate->copy()->subDays(6)->startOfDay();
        }

        $penjualan = Penjualan::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'ASC')->get();

        $penjualan->each(function ($penjualan) use (&$response, $reportType) {
            $date = Carbon::parse($penjualan->created_at);
            $title = $date->format('F');

            if ($reportType == "tahunan") {
                $title = $date->format("Y");
            } elseif ($reportType == "harian") {
                $title = $date->format("d");
            }

            if (!isset($response[$title])) $response[$title] = $penjualan->total_harga_jual;
            else  $response[$title] += $penjualan->total_harga_jual;
        });

        return ResponseFormatter::success($response);
    }
}
