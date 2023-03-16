<?php

namespace App\Helpers;

use App\Repositories\Interfaces\ICategoryRepository;

class StracePath
{
    private $categoryRepo;
    private $anyArray;

    public function __construct(ICategoryRepository $ICategoryRepository)
    {
        $this->anyArray = [];
        $this->categoryRepo = $ICategoryRepository;
    }

    public function stracePath($id, $nameItem): string
    {
        $categories = app('shared')->get('categories');
        $category = $categories->find($id);
        $this->parentCategoryRecursive($category->parent_id, $categories);
        $path = route('products.category', ['cateSlug' => $category->slug]);
        $this->anyArray = array_merge(array_reverse($this->anyArray), [
            '<li class="trace-item"><a href="' . $path . '"class="trace-item__link">' . $category->cate_name . '</a></li>',
            '<li class="trace-item"><span>' . $nameItem . '</span></li>']);
        return implode('', $this->anyArray);
    }

    public function parentCategoryRecursive($id, $listCategory): void
    {
        foreach ($listCategory as $v) {
            if ($v->id == $id) {
                $path = route('products.category', ['cateSlug' => $v->slug]);
                $this->anyArray[] = '<li class="trace-item"><a href="' . $path . '" class="trace-item__link">' . $v->cate_name . '</a></li>';
                if ($listCategory->contains('id', $v->parent_id)) $this->parentCategoryRecursive($v->parent_id, $listCategory);
            }
        }
    }
}
