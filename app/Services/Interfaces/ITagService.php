<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;

interface ITagService extends IBaseService
{
    public function firstOrCreate(array $tags): array;
}
