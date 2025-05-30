<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'supplier'), // تعيين الموردين كـ Guard افتراضي
        'passwords' => env('AUTH_PASSWORD_BROKER', 'suppliers'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'supplier' => [ // إضافة Guard جديد للموردين
            'driver' => 'session',
            'provider' => 'suppliers',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        'suppliers' => [ // إضافة الموردين كمزود بيانات
            'driver' => 'eloquent',
            'model' => App\Models\Supplier::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'suppliers' => [ // إضافة إعداد إعادة تعيين كلمة المرور للموردين
            'provider' => 'suppliers',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'supplier_password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
