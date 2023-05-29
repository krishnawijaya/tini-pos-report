<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Krishnawijaya\DodiUkirReport\Helpers\Toast;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class VoyagerBaseController extends BaseVoyagerBaseController
{
    public function store(Request $request)
    {
        if ($this->getSlug($request) == "barang") $request->request->add(["stok" => 0]);
        return parent::store($request);
    }

    public function destroy(Request $request, $id)
    {
        if ($this->getSlug($request) == "barang") {
            $ids = collect();

            if (empty($id)) $ids = collect(explode(',', $request->ids));
            else $ids->push($id);

            foreach ($ids as $id) {
                $barang = Barang::find($id);


                if ($barang) {
                    $relations = collect();

                    if ($barang->pembelian()->exists()) $relations->push("Pembelian");
                    if ($barang->persediaan()->exists()) $relations->push("Persediaan");
                    if ($barang->penjualan()->exists()) $relations->push("Penjualan");

                    if ($relations->count()) {
                        $relationsText = $relations->join(", ");

                        Toast::warning("Tidak dapat menghapus barang ($barang->nama_barang) karena telah tercatat di $relationsText.");
                        return redirect()->back();
                    }
                }
            }

            if ($ids->count() > 1) $id = null;
        }

        return parent::destroy($request, $id);
    }
}
