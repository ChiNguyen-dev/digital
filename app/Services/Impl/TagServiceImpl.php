<?php

namespace App\Services\Impl;

use App\Models\Tag;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ITagService;

class TagServiceImpl extends BaseService implements ITagService
{
    public function getModel(): string
    {
        return Tag::class;
    }

    public function firstOrCreate(array $condition, array $data): array
    {
        $data_result = array();
        foreach ($data as $tag) {
            $model = $this->model->firstOrCreate(['name' => $tag]);
            $data_result[] = $model->id;
        }
        return $data_result;
    }


}
