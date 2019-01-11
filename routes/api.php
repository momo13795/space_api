<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 2019/1/10
 * Time: 下午2:56
 */

$api = app('Dingo\Api\Routing\Router');



$api->version('v1', function ($api) use ($router) {


    $api->get('users', 'App\Http\Controllers\Controller@show');

    //登录注册授权
    $api->post('login', 'App\Http\Controllers\Auth\AuthController@login');
    $api->post('logout', 'App\Http\Controllers\Auth\AuthController@logout');
    $api->get('me', 'App\Http\Controllers\Auth\AuthController@me');


});

$api->version('v2', function ($api) use ($router) {
    $api->get('/a', function () use ($api,$router) {
        return 'hello';
    });
});