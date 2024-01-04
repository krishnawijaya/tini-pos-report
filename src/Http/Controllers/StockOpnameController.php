<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use KrishnaWijaya\TiniPosReport\Models\StockOpname;

class StockOpnameController extends Controller
{
    public $detailsView = "stock-opname-details";

    public function __construct(StockOpname $model)
    {
        parent::__construct($model);
    }
}
