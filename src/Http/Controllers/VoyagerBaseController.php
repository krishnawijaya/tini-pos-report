<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Krishnawijaya\DodiUkirReport\Models\Persediaan;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class VoyagerBaseController extends BaseVoyagerBaseController
{
    public function store(Request $request)
    {
        if ($this->getSlug($request) != "barang") return parent::store($request);

        $request->request->add(["_tagging" => true]);
        $result = parent::store($request);


        $barang = Barang::find($result->getData()->data->id_barang ?? 0);
        if ($barang) {
            $persediaan = Persediaan::create([
                "tanggal_persediaan" => now(),
                "total_persediaan" => $barang->stok,
                "total_harga_persediaan" => $barang->stok * $barang->harga,
            ]);

            $persediaan->barang()
                ->attach($barang->id_barang, [
                    'jenis' => "Pembuatan",
                    'harga' => $barang->harga,
                    'jumlah' => (int) $barang->stok,
                ]);
        }

        if ($barang && auth()->user()->can('browse', $barang)) {
            $redirect = redirect()->route("voyager.barang.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_added_new') . " Barang",
            'alert-type' => 'success',
        ]);
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
                    $persediaanIds = $barang->persediaan()->pluck('detail_persediaan.id_persediaan')->toArray();

                    $barang->persediaan()->detach();
                    Persediaan::whereIn('id_persediaan', $persediaanIds)->delete();
                }
            }

            if ($ids->count() > 1) $id = null;
        }

        return parent::destroy($request, $id);
    }
}
