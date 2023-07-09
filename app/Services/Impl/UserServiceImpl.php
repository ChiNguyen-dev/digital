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

    public function update($id, $data)
    {
        $user = $this->model->find($id);
        $user->update(
            collect($data)
                ->except('role_id')
                ->toArray()
        );
        $user->roles()->sync(
            $data['role_id']
        );
    }

    public function addRoleToUser($id, $roles)
    {
        return $this->model->find($id)->roles()->attach($roles);
    }

    public function getUsers(int $total)
    {
        return $this->model->latest()->paginate($total);
    }
}
