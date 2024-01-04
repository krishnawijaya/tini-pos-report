<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use Illuminate\Http\Request;
use KrishnaWijaya\TiniPosReport\Models\StockOpname;

class StockOpnameController extends Controller
{
    public function __construct(StockOpname $model)
    {
        parent::__construct($model);
    }
}
