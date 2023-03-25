<?php

namespace App\Repositories\Imp;

use App\Models\Permission;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\IPermissionRepository;

class PermissionRepositoryImp extends BaseRepository implements IPermissionRepository
{
    public function getModel()
    {
        return Permission::class;
    }
}
