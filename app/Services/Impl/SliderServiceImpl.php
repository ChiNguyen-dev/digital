<?php

namespace App\Services\Impl;

use App\Models\Slider;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ISliderService;

class SliderServiceImpl extends BaseService implements ISliderService
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
