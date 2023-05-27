<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Http\Request;
use Krishnawijaya\DodiUkirReport\Helpers\ResponseFormatter;

class BarangController extends Controller
{
    public function __construct(Barang $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = $this->queryBuilder();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [new Carbon($startDate), new Carbon($endDate)]);
        }

        $data = $query->latest()->get();
        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->findOrFail($id);
        return ResponseFormatter::success($data);
    }
}
