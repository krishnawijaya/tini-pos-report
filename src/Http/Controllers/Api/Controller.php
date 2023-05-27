<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Krishnawijaya\DodiUkirReport\Models\Persediaan;
use Illuminate\Routing\Controller as BaseController;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;
use Krishnawijaya\DodiUkirReport\Helpers\Toast;

class Controller extends BaseController
{
    public Model $model;
    protected Model $newRecord;
    protected Collection $listBarang;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModelName($forceLowerCase = false, $abbreviation = false)
    {
        $modelName = class_basename($this->model);

        if ($forceLowerCase) $modelName = strtolower($modelName);
        if ($abbreviation && strtolower($modelName) == "penjualan") $modelName = "jual";

        return $modelName;
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

        if ($this->getModelName() == "Penjualan") $query->with('user', 'pelanggan');
        $data = $query->latest()->get();

        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->findOrFail($id);

        return ResponseFormatter::success($data);
    }

    public function create(Request $request)
    {
        try {
            $totalHarga = 0;
            $totalJumlah = 0;

            $listBarang = collect($request->input('listBarang', []));

            $listBarang->each(function ($barangData) use (&$totalJumlah, &$totalHarga) {

                $barangData = collect($barangData);
                $barang = Barang::find($barangData->get('id_barang'));

                $harga = $barangData->get('harga', 0);
                $jumlah = (int) $barangData->get('jumlah', 0);

                if ($this->getModelName() == 'Penjualan') {
                    if ($barang->stok < $jumlah) throw new \Exception("Stok Barang Tidak Cukup");

                    $harga = $barang->harga;
                }

                $totalJumlah += $jumlah;
                $totalHarga += $harga * $jumlah;
            });

            $modelName = $this->getModelName(true, true);

            $newRecordData = collect([
                "tanggal_$modelName" => now(),
                "total_$modelName" => $totalJumlah,
                "total_harga_$modelName" => $totalHarga,
            ]);

            if ($modelName == "jual") {
                // TODO: Change database design, this logic will causing bug.
                $idPelanggan = $request->input('pelanggan')['id_pelanggan'] ?? 0;

                $newRecordData->put("id_user", auth()->user()->id);
                $newRecordData->put("id_pelanggan", $idPelanggan);
            }

            $this->listBarang = $listBarang;
            $this->newRecord = $this->queryBuilder()->create($newRecordData->toArray());
            $this->makeTransactions();

            Toast::success("{$this->getModelName()} berhasil dibuat!");
            return ResponseFormatter::success($this->newRecord);
        } catch (\Throwable $th) {

            Toast::error($th->getMessage());
            return ResponseFormatter::error($th->getMessage());
        }
    }

    protected function makeTransactions()
    {
        $this->listBarang->each(function ($barangData) {
            $actionType = $this->getModelName();

            $barangData = collect($barangData);
            $barang = Barang::find($barangData->get('id_barang'));

            $this->newRecord->barang()
                ->attach($barang->id_barang, [
                    'harga' => $actionType == "Penjualan" ? $barang->harga : $barangData->get('harga', 0),
                    'jumlah' => (int) $barangData->get('jumlah', 0),
                ]);

            if ($actionType == "Pembelian") $barang->stok += (int) $barangData->get('jumlah', 0);
            elseif ($actionType == "Penjualan") $barang->stok -= (int) $barangData->get('jumlah', 0);

            $barang->save();

            // Calculating Persediaan
            $totalHargaPerBarang = $barang->stok * $barang->harga;

            $persediaan = Persediaan::whereHas('barang', function ($barangQuery) use ($barangData) {
                $barangQuery->where('detail_persediaan.id_barang', $barangData->get('id_barang'));
            })->first();

            if (!$persediaan) $persediaan = new Persediaan();

            $persediaan->tanggal_persediaan = now();
            $persediaan->total_persediaan = $barang->stok;
            $persediaan->total_harga_persediaan = $totalHargaPerBarang;

            $persediaan->save();
            $persediaan->barang()
                ->attach($barang->id_barang, [
                    'jenis' => $actionType,
                    'harga' => $barang->harga,
                    'jumlah' => (int) $barangData->get('jumlah', 0),
                ]);
        });
    }
}
