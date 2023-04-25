<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Krishnawijaya\DodiUkirReport\Models\Persediaan;

class PersediaanController extends Controller
{
    public function __construct(Persediaan $model)
    {
        parent::__construct($model);
    }
}
