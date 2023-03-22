<?php

namespace App\Repositories\Imp;

use App\Models\User;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\IUserRepository;

class UserRepositoryImp extends BaseRepository implements IUserRepository
{

    public function getModel(): string
    {
        return User::class;
    }
}
