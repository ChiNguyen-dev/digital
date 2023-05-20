<?php

namespace App\Helpers;

class CategoryRecursive
{
    private int $index;
    private $categories;
    private string $htmlOption;
    public function __construct()
    {
        $this->init();
    }

    public function init(): void
    {
        $this->index = 0;
        $this->htmlOption = '';
        $this->categories = app('shared')->get('categories');
    }

    // ADMIN
    public function categoryRecursive($parent_id = 0, $id = 0, $text = '|--'): string
    {
        foreach ($this->categories as $v) {
            if ($v->parent_id == $id) {
                $selected = ($v->id == $parent_id and !empty($parent_id)) ? 'selected' : '';
                $this->htmlOption .= '<option ' . $selected . ' value="' . $v->id . '">' . $text . $v->cate_name . '</option>';
                $this->categoryRecursive($parent_id, $v->id, $text . '--');
            }
        }
        return $this->htmlOption;
    }

    public function dataMapNameCategory($data = null, $id = 0, $text = '|--')
    {
        foreach ($data as $v) {
            if ($v->parent_id == $id) {
                $v->cate_name = $text . $v->cate_name;
                if ($data->contains('parent_id', $v->id))
                    $this->dataMapNameCategory($data, $v->id, $text . '--');
            }
        }
        return $data;
    }


    // Menu Client
    public function megaMenuRecursive($parent_id = 0): string
    {
        if ($parent_id != 0) $this->htmlOption .= '<ul class="sub-menu">';
        foreach ($this->categories as $category) {
            if ($category->parent_id == $parent_id) {
                $icon = $this->categories->contains('parent_id', $category->id) && $category->parent_id != 0 ? '<i class="fa-solid fa-angle-right"></i>' : '';
                $this->htmlOption .= '<li><a href="' . route('products.category', ['cateSlug' => $category->slug]) . '">' . $category->cate_name . $icon . '</a>';
                if ($this->categories->contains('parent_id', $category->id)) $this->megaMenuRecursive($category->id);
            }
        }
        if ($parent_id != 0) $this->htmlOption .= '</ul>';
        return $this->htmlOption;
    }

    public function menuResponsiveRecursive($id = 0): string
    {
        if ($id != 0) $this->htmlOption .= '<ul class="sub-menu">';
        foreach ($this->categories as $value) {
            if ($value->parent_id == $id) {
                $this->htmlOption .= "<li><div class='title'><a href='" . route('products.category', ['cateSlug' => $value->slug]) . "'>" . $value->cate_name . "</a>";
                if ($this->categories->contains('parent_id', $value->id)) {
                    $this->htmlOption .= "<i class='fa-solid fa-plus'></i></div>";
                    $this->menuResponsiveRecursive($value->id);
                } else {
                    $this->htmlOption .= '</div></li>';
                }
            }
        }
        if ($id != 0) $this->htmlOption .= '</ul>';
        return $this->htmlOption;
    }

    public function menuSidebarRecursive($id = 0, $index = 0): string
    {
        $this->htmlOption .= $id == 0 ? '<ul>' : '<ul class="sub-menu level' . '-' . $index . '">';
        foreach ($this->categories as $category) {
            if ($category->parent_id == $id) {
                $this->index++;
                $this->htmlOption .= '<li><div class="d-flex align-items-center justify-content-between">
                                                <a href="' . route('products.category', ['cateSlug' => $category->slug]) . '">' . $category->cate_name . '</a>
                                                <span class="fa-solid fa-angle-down icon-toggle" data-submenu="level-' . $this->index . '"></span>
                                           </div>';
                $this->categories->contains('parent_id', $category->id) ? $this->menuSidebarRecursive($category->id, $this->index) : $this->index = 0;
                $this->htmlOption .= '</li>';
            }
        }
        $this->htmlOption .= '</ul>';
        return $this->htmlOption;
    }


    public function menu(...$data): array
    {
        $listMenu = array();
        foreach ($data as $v) {
            switch ($v) {
                case 'megaMenuHeader':
                    $listMenu['megaMenuHeader'] = $this->megaMenuRecursive();
                    break;
                case 'menuResponse':
                    $listMenu['menuResponse'] = $this->menuResponsiveRecursive();
                    break;
                case 'menuSidebar':
                    $listMenu['menuSidebar'] = $this->menuSidebarRecursive();
                    break;
            }
            $this->htmlOption = '';
        }
        return $listMenu;
    }
}
