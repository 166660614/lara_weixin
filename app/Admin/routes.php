<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/weixin/usersinfo',WxUserController::class);
    $router->get('/weixin/token', 'WxUserController@getAccessToken');
    $router->get('/weixin/user/info', 'WxUserController@getUserInfo');
    $router->get('/weixin/usersinfo/chat?user_id={$user_id}', 'WxUserController@kfChat');
    $router->get('/weixin/users/send', 'WxUserController@sendAllView');
    $router->post('/weixin/send/all', 'WxUserController@sendAllAction');

});
