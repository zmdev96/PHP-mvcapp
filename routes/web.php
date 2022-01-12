<?php
/*
|--------------------------------------------------------------------------
| Route File
|--------------------------------------------------------------------------
| 'URL: controller/action/pahrms' => ['Class and Method: Home@Index[$id]' , 'Request Method: get']
|
*/

return [
    'routes' => [
        '/'                       => ['Home@index',     'get'],
        'home'                    => ['Home@index',     'get'],
        'home/index'              => ['Home@index',     'get'],
        'users'                   => ['Users@index',    'get'],
        'users/index'             => ['Users@index',    'get'],
        'users/create'            => ['Users@create',   'get'],
        'users/store'             => ['Users@store',    'post'],
        'users/edit/id/:int'      => ['Users@edit',     'get'],
        'users/update'            => ['Users@update',   'post'],
        'users/delete/:int'       => ['Users@delete',   'get'],
        'notfound/index'          => ['Notfound@index', 'get'],
        'auth/login'              => ['Auth/Login@login',   'get'],
        'auth/login/submit'       => ['Auth/Login@submit',   'post'],
        'auth/logout'              => ['Auth/Logout@logout',   'get'],




        // Dashboard Rotes List

        'app-admin'                         => ['Admin/Home@index',     'get'],
        'app-admin/home'                    => ['Admin/Home@index',     'get'],
        'app-admin/home/index'              => ['Admin/Home@index',     'get'],
        'app-admin/home/name'               => ['Admin/Home@name',     'get'],
        'app-admin/users'                   => ['Admin/Users@index',    'get'],
        'app-admin/users/index'             => ['Admin/Users@index',    'get'],
        'app-admin/users/create'            => ['Admin/Users@create',   'get'],
        'app-admin/users/store'             => ['Admin/Users@store',    'post'],
        'app-admin/users/edit/:int'         => ['Admin/Users@edit',     'get'],
        'app-admin/users/update'            => ['Admin/Users@update',   'post'],
        'app-admin/users/show/:int'         => ['Admin/Users@show',   'get'],
        'app-admin/users/delete/:int'       => ['Admin/Users@delete',   'get'],
        'app-admin/auth/login'              => ['Auth/Login@login',   'get'],
        'app-admin/auth/logout'             => ['Auth/Logout@logout',   'get'],
        'app-admin/test'                    => ['Admin/Test@index',     'get'],
        'app-admin/test/stream'             => ['Admin/Test@stream',     'get'],
        'app-admin/test/time'               => ['Admin/Test@time',     'get'],

        // System Routes List
        'language/local/:alpha'             => ['Language@index',    'get'],
        'accessdenid/index'                 => ['Accessdenid@index', 'get'],

    ],
];
