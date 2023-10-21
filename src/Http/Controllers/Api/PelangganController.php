<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use KrishnaWijaya\TiniPosReport\Helpers\ResponseFormatter;

class PelangganController extends Controller
{
    public function __construct(Pelanggan $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $data = $this->queryBuilder()->latest()->get();
        return ResponseFormatter::success($data);
    }

    public function show(Request $request, $id)
    {
        $data = $this->queryBuilder()->findOrFail($id);
        return ResponseFormatter::success($data);
    }
}
