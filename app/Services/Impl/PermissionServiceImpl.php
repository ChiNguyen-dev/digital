<?php

namespace App\Services\Impl;

use App\Models\Permission;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IPermissionService;

class PermissionServiceImpl extends BaseService implements IPermissionService
{
    public function getModel(): string
    {
        return Permission::class;
    }
}
