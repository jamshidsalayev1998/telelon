<?php

return [
    'permissions' => [
        'permission-store',
        'permission-update',
        'permission-delete',
        'permission-index',
        'permission-show',
        'role-store',
        'role-update',
        'role-delete',
        'role-index',
        'role-show',
        'login',
        'register',
        'product-store',
        'product-index',
        'product-show',
        'product-update',
        'product-delete',
        'category-store',
        'category-index',
        'category-show',
        'category-update',
        'category-delete',
        'brand-store',
        'brand-index',
        'brand-show',
        'brand-update',
        'brand-delete',
    ],
    'roles' => [
        'super-admin' => [
            'permission-store',
            'permission-update',
            'permission-delete',
            'permission-index',
            'permission-show',
            'role-store',
            'role-update',
            'role-delete',
            'role-index',
            'role-show',
            'category-store',
            'category-index',
            'category-show',
            'category-update',
            'category-delete',
            'brand-store',
            'brand-index',
            'brand-show',
            'brand-update',
            'brand-delete',
        ],
        'simple-user' => [
            'login',
            'register',
            'product-store',
            'product-index',
            'product-show',
            'product-update',
            'product-delete',
            'category-index',
            'category-show',
            'brand-index',
            'brand-show',
        ]
    ],
    'users' => [
        [
            'name' => 'SuperAdmin',
            'roles' => ['super-admin'],
            'login' => '994571669'
        ],
        [
            'name' => 'SuperAdmin2222',
            'roles' => ['super-admin'],
            'login' => '111111111'
        ]
    ],
    'default-languages' => [
        [
            'name' => 'O`zbek',
            'key' => 'uz'
        ],
        [
            'name' => 'Rus',
            'key' => 'ru'
        ]
    ]
];
