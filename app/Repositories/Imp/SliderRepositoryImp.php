<?php

namespace App\Repositories\Imp;

use App\Models\Slider;
use App\Repositories\Abstracts\BaseRepository;
use App\Repositories\Interfaces\ISliderRepository;

class SliderRepositoryImp extends BaseRepository implements ISliderRepository
{

    public function getModel()
    {
        return Slider::class;
    }

    public function getSliderByImageName($imageName)
    {
        return $this->model->where('image_name', $imageName)->first();
    }
}
