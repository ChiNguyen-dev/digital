<?php

namespace App\Helpers;


use App\Models\Permission;

class Recursive
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function permissionRecursive($parent_id = null): string
    {
        $data = '';
        $permissionsParent = $this->permission->where('parent_id', 0)->get();
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
