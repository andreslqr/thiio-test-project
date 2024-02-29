<?php


return [
    'prefix' => 'v1',
    'name' => 'v1.',
    'middleware' => [
        'api',
        'auth:api'
    ],
    'routes-path' => base_path('routes/v1')
];