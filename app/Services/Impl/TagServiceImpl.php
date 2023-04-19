<?php

namespace App\Services\Impl;

use App\Models\Tag;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\ITagService;

class TagServiceImpl extends BaseService implements ITagService
{
    public function getModel()
    {
        return Tag::class;
    }

    public function firstOrCreate(array $tags): array
    {
        return collect($tags)
                ->map(fn ($tag) => $this->model->firstOrCreate(['name' => $tag])->id)
                ->toArray();
    }
}
