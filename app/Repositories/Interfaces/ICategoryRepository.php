<?php

namespace App\Repositories\Interfaces;

interface ICategoryRepository extends IBaseRepository
{
    public function findMultipleBySlug(...$data);

    public function findBySlug($slug);
}
