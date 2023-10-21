<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use KrishnaWijaya\TiniPosReport\Helpers\Toast;
use KrishnaWijaya\TiniPosReport\Helpers\ResponseFormatter;
use KrishnaWijaya\TiniPosReport\Http\Controllers\Base\Controller as BaseController;

class Controller extends BaseController
{
    protected Model $newRecord;
    protected Collection $listBarang;

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = $this->queryBuilder()->with('barang');

        if ($startDate && $endDate) {
            $startDate = new Carbon($startDate);
            $endDate = new Carbon($endDate);

            $query->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
        }

        $data = $query->latest()->get();
        if ($this->getModelName() == "Penjualan") $data->load('user', 'pelanggan');

        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->with('barang')->findOrFail($id);
        if ($this->getModelName() == "Penjualan") $data->load('user', 'pelanggan');

        return ResponseFormatter::success($data);
    }

    public function create(Request $request)
    {
        try {
            $totalHarga = 0;
            $totalJumlah = 0;

            $listBarang = collect($request->input('listBarang', []));
            if ($listBarang->isEmpty()) throw new \Exception("Mohon setidaknya tambahkan 1 barang");

            $listBarang->each(function ($barangData) use (&$totalJumlah, &$totalHarga) {

                $barangData = collect($barangData);
                $barang = Barang::find($barangData->get('id_barang'));

                $harga = $barangData->get('harga', 0);
                $jumlah = (int) $barangData->get('jumlah', 0);

                if ($this->getModelName() == 'Penjualan') {
                    if ($barang->stok < $jumlah) throw new \Exception("Stok barang ($barang->nama_barang) tidak cukup");

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

                $newRecordData->put("id_user", Auth::user()->id);
                $newRecordData->put("id_pelanggan", $idPelanggan);
            }

            $this->listBarang = $listBarang;
            $this->newRecord = $this->queryBuilder()->create($newRecordData->toArray());
            $this->makeTransactions();

            if (!Auth::user()->isKasir()) Toast::success("{$this->getModelName()} berhasil dibuat");

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
        });
    }
}
