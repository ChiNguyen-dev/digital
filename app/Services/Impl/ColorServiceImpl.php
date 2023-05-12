<?php

namespace App\Services\Impl;

use App\Models\Color;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IColorService;

class ColorServiceImpl extends BaseService implements IColorService
{

    public function getModel(): string
    {
        return Color::class;
    }
}
