<?php

namespace App\Services\Interfaces;
interface IUserService extends IBaseService
{
    public function searchUsers($emailOrName);

    public function getUsers(int $total);

    public function addRoleToUser($id, $roles);
}
