<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use KrishnaWijaya\TiniPosReport\Models\Persediaan;

class PersediaanController extends Controller
{
    public function __construct(Persediaan $model)
    {
        $this->detailsView = "persediaan-details";
        $this->createView = "persediaan-create";

        parent::__construct($model);
    }
}
