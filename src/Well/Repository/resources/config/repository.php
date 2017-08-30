<?php
/*
|--------------------------------------------------------------------------
| Well Repository Config
|--------------------------------------------------------------------------
|
|
*/
return [
    /*
    |--------------------------------------------------------------------------
    | Generator Config
    |--------------------------------------------------------------------------
    |
    */
    'generator' => [
        'base_path' => app_path(),
        'root_namespace' => 'App\\',
        'paths' => [
            'models' => 'Entities',
            'repositories' => 'Repositories',
	        'migrations' => 'database/migrations',
            'controllers' => 'Http/Controllers',
        ]
    ]
];