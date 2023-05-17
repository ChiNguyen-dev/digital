<?php

namespace App\Services\Interfaces;

interface IPermissionService extends IBaseService
{
    public function getSelectionPermission($active_id = null, $str = ''): string;
}
