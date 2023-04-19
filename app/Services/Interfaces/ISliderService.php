<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\IBaseService;


interface ISliderService extends IBaseService
{
    public function getSliderByImageName($imageName);
}
