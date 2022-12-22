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
        'product-show',
        'product-update',
        'product-delete'
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
        ],
        'simple-user' => [
            'login',
            'register',
            'product-store',
            'product-show',
            'product-update',
            'product-delete'
        ]
    ],
    'users' => [
        [
            'name' => 'SuperAdmin',
            'roles' => ['super-admin'],
            'login' => '994571669'
        ]
    ]
];
