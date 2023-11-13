<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Supplier;
use Illuminate\Http\Request;
use KrishnaWijaya\TiniPosReport\Helpers\ResponseFormatter;

class SupplierController extends Controller
{
    public function __construct(Supplier $model)
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
