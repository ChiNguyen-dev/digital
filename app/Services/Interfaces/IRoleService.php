<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;


interface IRoleService extends IBaseService
{
    public function addPermissionToRole($roleId, $permissions);

    public function updatePermissionToRole($roleId, $permissions);
}
