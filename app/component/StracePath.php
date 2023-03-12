<?php

namespace App\component;

use App\Models\Category;

class StracePath
{
    private $category;
    private $anyArray;

    public function __construct(Category $category)
    {
        $this->anyArray = [];
        $this->category = $category;
    }

    public function stracePath($id, $nameItem): string
    {
        $listCategory = $this->category->all();
        $category = $this->category->find($id);
        $this->parentCategoryRecursive($category->parent_id, $listCategory);
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
