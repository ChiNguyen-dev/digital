<?php

namespace App\Traits;

trait HandleCategoryTrait
{
    private $data;
    private $ids = [];


    public function getIdBySlug(...$slug): array
    {
        $listId = [];
        $categories = $this->data->whereIn('slug', $slug);
        if (!empty($categories)) {
            foreach ($categories as $v) {
                $listId[$v->slug] = $this->cateIds($v->id);
                $this->ids = [];
            }
        }
        return $listId;
    }

    public function cateIds($id): array
    {
        $this->ids[] = $id;
        $this->findCategoryChildrent($id);
        return $this->ids;
    }

    public function findCategoryChildrent($id): void
    {
        foreach ($this->data as $category) {
            if ($category->parent_id == $id) {
                $this->ids[] = $category->id;
                if ($this->data->contains('parent_id', $category->id)) {
                    $this->findCategoryChildrent($category->id);
                }
            }
        }
    }

    public function setDataCateTrait($data)
    {
        $this->data = $data;
    }
}
