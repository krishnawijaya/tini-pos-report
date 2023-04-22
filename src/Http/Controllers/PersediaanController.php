<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use App\Models\Persediaan;
use Illuminate\Support\Facades\Request;

class PersediaanController extends Controller
{
    public function __construct(Persediaan $model)
    {
        parent::__construct($model);
    }
}
