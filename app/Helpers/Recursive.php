<?php

namespace App\Helpers;


use App\Repositories\Interfaces\IPermissionRepository;

class Recursive
{
    private $permissionRepo;

    public function __construct(IPermissionRepository $iPermissionRepository)
    {
        $this->permissionRepo = $iPermissionRepository;
    }

    public function permissionRecursive($parent_id = null): string
    {
        $data = '';
        $permissionsParent = $this->permissionRepo->getAllByWhere('parent_id', 0)->load('permissions');
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
