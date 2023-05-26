<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;

class Controller extends BaseController
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModelName()
    {
        return class_basename($this->model);
    }

    public function getModelIcon()
    {
        return $this->model::ICON;
    }

    public function queryBuilder()
    {
        return $this->model::query();
    }

    public function index(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = $this->queryBuilder();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [new Carbon($startDate), new Carbon($endDate)]);
        }

        if (strtolower($this->getModelName()) == "penjualan") {
            $query->with('user', 'pelanggan');
        }

        $data = $query->get();

        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->findOrFail($id);

        return ResponseFormatter::success($data);
    }

    public function create(Request $request)
    {
        $listBarang = collect($request->input('listBarang', []));
        $pelanggan = $request->input('pelanggan');

        $totalHarga = 0;
        $totalJumlah = 0;

        $listBarang->map(function ($barang) use (&$totalJumlah, &$totalHarga) {
            $jumlah = (int) $barang['jumlah'] ?? 0;
            $harga = (int) $barang['harga'] ?? 0;

            $totalJumlah += $jumlah;
            $totalHarga += $harga * $jumlah;

            return new Barang($barang);
        });

        $modelName = strtolower($this->getModelName());
        if ($modelName == "penjualan") $modelName = "jual";

        $newRecord = $this->queryBuilder()->create([
            "id_user" => auth()->user()->id,
            "id_pelanggan" => $pelanggan['id_pelanggan'],

            "tanggal_$modelName" => new Carbon(),
            "total_$modelName" => $totalJumlah,
            "total_harga_$modelName" => $totalHarga,
        ]);

        return ResponseFormatter::success($newRecord);
    }
}
