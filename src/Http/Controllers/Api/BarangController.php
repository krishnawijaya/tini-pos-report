<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Http\Request;
use KrishnaWijaya\TiniPosReport\Helpers\ResponseFormatter;

class BarangController extends Controller
{
    public function __construct(Barang $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $data = $this->queryBuilder()->with('kategori')->latest()->get();
        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->with('kategori')->findOrFail($id);
        return ResponseFormatter::success($data);
    }
}
