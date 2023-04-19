<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseCartService;

interface ICartService extends IBaseCartService
{
    public function updateQtyById($id, $qty): void;

    public function removeItemById($id): void;

    public function updateColorById($id, $data);
}
