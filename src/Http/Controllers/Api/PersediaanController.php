<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use App\Models\Barang;
use Illuminate\Http\Request;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;
use Krishnawijaya\DodiUkirReport\Helpers\Toast;
use Krishnawijaya\DodiUkirReport\Models\Persediaan;

class PersediaanController extends Controller
{
    public const TYPE_RAW_MATERIAL = "RawMaterial";
    public const TYPE_FINISHED_GOODS = "FinishedGoods";

    public function __construct(Persediaan $model)
    {
        parent::__construct($model);
    }

    public function create(Request $request)
    {
        try {
            $listRawMaterial = collect($request->input('listRawMaterial', []));
            $listFinishedGoods = collect($request->input('listFinishedGoods', []));

            if ($listRawMaterial->isEmpty()) throw new \Exception("Mohon setidaknya tambahkan 1 bahan baku");
            if ($listFinishedGoods->isEmpty()) throw new \Exception("Mohon setidaknya tambahkan 1 barang jadi");

            $persediaan = $this->queryBuilder()->create([
                "tanggal_persediaan" => now(),
                "total_persediaan" => 0,
                "total_harga_persediaan" => 0,
            ]);

            $listRawMaterial->each(function ($barangData) use ($persediaan) {

                $barangData = collect($barangData);
                $barang = Barang::find($barangData->get('id_barang'));

                $jumlah = (int) $barangData->get('jumlah', 0);
                if ($barang->stok < $jumlah) throw new \Exception("Stok bahan baku ($barang->nama_barang) tidak cukup");

                $barang->stok -= $jumlah;
                $barang->save();

                $persediaan->barang()
                    ->attach($barang->id_barang, [
                        'jenis' => self::TYPE_RAW_MATERIAL,
                        'harga' => $barang->harga,
                        'jumlah' => $jumlah,
                    ]);
            });

            $totalHargaFinishedGoods = 0;
            $totalJumlahFinishedGoods = 0;

            $listFinishedGoods->each(function ($barangData) use ($persediaan, &$totalJumlahFinishedGoods, &$totalHargaFinishedGoods) {

                $barangData = collect($barangData);
                $barang = Barang::find($barangData->get('id_barang'));

                $jumlah = (int) $barangData->get('jumlah', 0);

                $barang->stok += $jumlah;
                $barang->save();

                $persediaan->barang()
                    ->attach($barang->id_barang, [
                        'jenis' => self::TYPE_FINISHED_GOODS,
                        'harga' => $barang->harga,
                        'jumlah' => $jumlah,
                    ]);

                $totalJumlahFinishedGoods += $jumlah;
                $totalHargaFinishedGoods += $barang->harga * $jumlah;
            });

            $persediaan->total_persediaan = $totalJumlahFinishedGoods;
            $persediaan->total_harga_persediaan = $totalHargaFinishedGoods;

            $persediaan->save();
        } catch (\Throwable $th) {

            Toast::error($th->getMessage());
            return ResponseFormatter::error($th->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->with('barang.kategori')->findOrFail($id);

        $listRawMaterial = $data->barang->filter(function ($barang) {
            return $barang->pivot->jenis == self::TYPE_RAW_MATERIAL;
        })->values();

        $listFinishedGoods = $data->barang->filter(function ($barang) {
            return $barang->pivot->jenis == self::TYPE_FINISHED_GOODS;
        })->values();

        return ResponseFormatter::success(compact('listRawMaterial', 'listFinishedGoods'));
    }
}
