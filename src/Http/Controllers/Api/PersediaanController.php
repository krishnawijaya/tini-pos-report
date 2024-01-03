<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers\Api;

use KrishnaWijaya\TiniPosReport\Models\Persediaan;

class PersediaanController extends Controller
{
    public function __construct(Persediaan $model)
    {
        parent::__construct($model);
    }
}
