<?php

namespace App\Repositories\Imp;

use App\Models\Color;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\IColorRepository;

class ColorRepositoryImp extends BaseRepository implements IColorRepository
{

    public function getModel()
    {
        return Color::class;
    }
}
