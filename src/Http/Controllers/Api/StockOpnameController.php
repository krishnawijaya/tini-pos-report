<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use App\Models\Barang;
use Illuminate\Http\Request;
use KrishnaWijaya\TiniPosReport\Helpers\Toast;
use KrishnaWijaya\TiniPosReport\Models\StockOpname;
use KrishnaWijaya\TiniPosReport\Helpers\ResponseFormatter;
use KrishnaWijaya\TiniPosReport\Models\Penyesuaian;

class StockOpnameController extends Controller
{
    public function __construct(StockOpname $model)
    {
        parent::__construct($model);
    }

    public function create(Request $request)
    {
        try {
            $totalHargaNyata = 0;
            $totalJumlahNyata = 0;
            $totalHargaTercatat = 0;
            $totalJumlahTercatat = 0;

            $listBarang = collect($request->input('listBarang', []));
            if ($listBarang->isEmpty()) throw new \Exception("Mohon setidaknya tambahkan 1 barang");

            $listBarang->each(function ($barangData) use (&$totalJumlahNyata, &$totalHargaNyata, &$totalJumlahTercatat, &$totalHargaTercatat) {
                $barangData = collect($barangData);
                $barang = Barang::find($barangData->get('id_barang'));

                $jumlahTercatat = $barang->stok;
                $jumlahNyata = (int) $barangData->get('jumlah', 0);

                $totalJumlahNyata += $jumlahNyata;
                $totalHargaNyata += $barang->harga * $jumlahNyata;

                $totalJumlahTercatat += $jumlahTercatat;
                $totalHargaTercatat += $barang->harga * $jumlahTercatat;
            });

            $newRecordData = collect([
                "tanggal" => now(),

                'total_nyata' => $totalJumlahNyata,
                'total_harga_nyata' => $totalHargaNyata,

                'total_tercatat' => $totalJumlahTercatat,
                'total_harga_tercatat' => $totalHargaTercatat,
            ]);

            $this->listBarang = $listBarang;
            $this->newRecord = $this->queryBuilder()->create($newRecordData->toArray());

            Penyesuaian::create(['nilai' => $totalHargaNyata - $totalHargaTercatat]);

            $this->makeTransactions();
            return ResponseFormatter::success($this->newRecord);
        } catch (\Throwable $th) {

            Toast::error($th->getMessage());
            return ResponseFormatter::error($th->getMessage());
        }
    }

    protected function makeTransactions()
    {
        $this->listBarang->each(function ($barangData) {
            $barangData = collect($barangData);

            $jumlahNyata = (int) $barangData->get('jumlah', 0);
            $barang = Barang::find($barangData->get('id_barang'));

            $this->newRecord->barang()
                ->attach($barang->id_barang, [
                    'harga' => $barang->harga,
                    'alasan' => $barangData->get('alasan', ""),

                    'jumlah_nyata' => $jumlahNyata,
                    'jumlah_tercatat' => $barang->stok,
                ]);

            $barang->stok = $jumlahNyata;
            $barang->save();
        });
    }
}
