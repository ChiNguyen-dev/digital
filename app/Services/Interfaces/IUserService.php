<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;

interface IUserService extends IBaseService
{
    public function searchUsers($emailOrName);

    public function addRoleToUser($id, $roles);

    public function updateRoleToUser($id, $roles);

    public function countSoftDeletedUsers();
}
