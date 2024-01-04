<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use KrishnaWijaya\TiniPosReport\Models\Persediaan;

class PersediaanController extends Controller
{
    public $detailsView = "persediaan-details";

    public function __construct(Persediaan $model)
    {
        parent::__construct($model);
    }
}
