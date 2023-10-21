<?php

namespace KrishnaWijaya\TiniPosReport\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerRoleController as BaseVoyagerRoleController;

class VoyagerRoleController extends BaseVoyagerRoleController
{
    public function store(Request $request)
    {
        $this->addMandatoryPermission($request);
        return parent::store($request);
    }

    public function update(Request $request, $id)
    {
        $this->addMandatoryPermission($request);
        return parent::update($request, $id);
    }

    protected function addMandatoryPermission(Request $request)
    {
        $permissions = collect($request->input('permissions', []));

        // Add browse_admin permission id
        $permissions->put(1, "1");

        $request->request->add(["permissions" => $permissions]);
    }
}
