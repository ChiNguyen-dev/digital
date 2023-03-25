<?php

namespace App\Repositories\Interfaces;

interface IUserRepository extends IBaseRepository
{
    public function searchUsers($emailOrName);

    public function addRoleToUser($id, $roles);

    public function updateRoleToUser($id, $roles);

    public function countSoftDeletedUsers();
}
