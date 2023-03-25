<?php

namespace App\Repositories\Imp;

use App\Models\Role;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\IRoleRepository;

class RoleRepositoryImp extends BaseRepository implements IRoleRepository
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
