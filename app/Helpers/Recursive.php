<?php

namespace App\Helpers;

use App\Services\Interfaces\IPermissionService;

class Recursive
{
    private IPermissionService $permissionService;

    public function __construct(IPermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function permissionRecursive($parent_id = null): string
    {
        $data = '';
        $permissionsParent = $this->permissionService->getAllByWhere('parent_id', 0)->load('permissions');
        foreach ($permissionsParent as $permissionParent) {
            if ($permissionParent->id == $parent_id) {
                $data .= '<option selected value="' . $permissionParent->id . '">' . '|--' . $permissionParent->name . '</option>';
            }
            $data .= '<option value="' . $permissionParent->id . '">' . '|--' . $permissionParent->name . '</option>';
            $permissionsChildrent = $permissionParent->permissions;
            foreach ($permissionsChildrent as $permissionChildrent) {
                $data .= '<option value="' . $permissionChildrent->id . '">' . '|----' . $permissionChildrent->name . '</option>';
            }
        }
        return $data;
    }
}
