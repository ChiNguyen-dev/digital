<?php

namespace App\Services\Impl;

use App\Models\Role;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IRoleService;

class RoleServiceImpl extends BaseService implements IRoleService
{
    public function getModel()
    {
        return Role::class;
    }

    public function addPermissionToRole($roleId, $permissions)
    {
        return $this->model->find($roleId)
                           ->permissions()
                           ->attach($permissions);
    }

    public function updatePermissionToRole($roleId, $permissions) {
        return $this->model->find($roleId)
                           ->permissions()
                           ->sync($permissions);
    }
}
