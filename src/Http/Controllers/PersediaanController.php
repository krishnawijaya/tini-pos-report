<?php

namespace Krishnawijaya\DodiUkirReport\Http\Controllers;

use Krishnawijaya\DodiUkirReport\Models\Persediaan;

class PersediaanController extends Controller
{
    public function __construct(Persediaan $model)
    {
        $this->detailsView = "persediaan-details";
        $this->createView = "persediaan-create";

        parent::__construct($model);
    }
}
