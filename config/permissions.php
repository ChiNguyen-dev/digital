<?php

return [
    'modules' => [
        'products' => [
            'show' => 'product-show',
            'add' => 'product-add',
            'edit' => 'product-edit',
            'delete' => 'product-delete',
        ],
        'categories' => [
            'show' => 'category-show',
            'add' => 'category-add',
            'edit' => 'category-edit',
            'delete' => 'category-delete',
        ],
        'colors' => [
            'show' => 'color-show',
            'add' => 'color-add',
            'edit' => 'color-edit',
            'delete' => 'color-delete',
        ],
        'sliders' => [
            'show' => 'slider-show',
            'add' => 'slider-add',
            'edit' => 'slider-edit',
            'delete' => 'slider-delete',
        ],
        'orders' => [
            'show' => 'order-show',
            'update' => 'order-update',
            'delete' => 'order-delete',
        ],
        'customers' => [
            'show' => 'customer-show',
            'delete' => 'customer-delete',
        ],
    ],
    'permissions' => [
        'products' => [
            'show' => 'product-show',
            'add' => 'product-add',
            'edit' => 'product-edit',
            'delete' => 'product-delete',
        ],
        'categories' => [
            'show' => 'category-show',
            'add' => 'category-add',
            'edit' => 'category-edit',
            'delete' => 'category-delete',
        ],
        'colors' => [
            'show' => 'color-show',
            'add' => 'color-add',
            'edit' => 'color-edit',
            'delete' => 'color-delete',
        ],
        'sliders' => [
            'show' => 'slider-show',
            'add' => 'slider-add',
            'edit' => 'slider-edit',
            'delete' => 'slider-delete',
        ],
        'orders' => [
            'show' => 'order-show',
            'update' => 'order-update',
            'delete' => 'order-delete',
        ],
        'customers' => [
            'show' => 'customer-show',
            'delete' => 'customer-delete',
        ],
    ],
    'guards' => [
        'isAdmin' => 'isAdmin',
        'isPermissionEdit' => 'permission-edit',
        'isPermissionDelete' => 'permission-delete'
    ],
];
