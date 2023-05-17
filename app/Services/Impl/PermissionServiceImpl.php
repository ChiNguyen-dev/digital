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

    public function getSelectionPermission($active_id = null, $str = ''): string
    {
        $permissionsParent = $this->model->with('permissions')->where('parent_id', 0)->get();
        foreach ($permissionsParent as $parent) {
            if ($parent->id == $active_id) {
                $str .= '<option selected value="' . $parent->id . '">' . '|--' . $parent->name . '</option>';
            }
            $str .= '<option value="' . $parent->id . '">' . '|--' . $parent->name . '</option>';
            $permissionsChildren = $parent->permissions;
            foreach ($permissionsChildren as $permissionChildren) {
                $str .= '<option value="' . $permissionChildren->id . '">' . '|----' . $permissionChildren->name . '</option>';
            }
        }
        return $str;
    }
}
