<?php

namespace App\Repositories\Interfaces;

interface IRoleRepository extends IBaseRepository
{
    public function addPermissionToRole($roleId, $permissions);

    public function updatePermissionToRole($roleId, $permissions);
}
