<?php

namespace App\Services\package;

interface ICartPackage extends IBaseCartPackage
{
    public function updateQtyById($id, $qty): void;

    public function removeItemById($id): void;

    public function updateColorById($id, $data);
}
