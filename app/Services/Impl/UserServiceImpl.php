<?php
namespace App\Services\Impl;

use App\Models\User;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IUserService;

class UserServiceImpl extends BaseService implements IUserService
{

    public function getModel(): string
    {
        return User::class;
    }

    public function searchUsers($emailOrName)
    {
        return $this->model->where('name', 'Like', "%{$emailOrName}%")
            ->orWhere('email', 'Like', "%{$emailOrName}%")
            ->latest()->paginate(15);
    }

    public function updateRoleToUser($id, $roles)
    {
        return $this->model->find($id)->roles()->sync($roles);
    }

    public function addRoleToUser($id, $roles)
    {
        return $this->model->find($id)->roles()->attach($roles);
    }

    public function countSoftDeletedUsers()
    {
        return $this->model->onlyTrashed()->count();
    }
}
