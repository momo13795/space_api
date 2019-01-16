<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 2019/1/10
 * Time: 下午2:56
 */

$api = app('Dingo\Api\Routing\Router');



$api->version('v1', function ($api) use ($router) {

    //登录路由组(频率限制)
    $api->group([
        'middleware' => ['api.throttle'],
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ],function ($api) {
        $api->post('login', 'App\Http\Controllers\Auth\AuthController@login');
        $api->post('register', 'App\Http\Controllers\Auth\AuthController@register');
    });


    $api->get('users', 'App\Http\Controllers\Controller@show');

    //登录注册授权
    $api->post('logout', 'App\Http\Controllers\Auth\AuthController@logout');
    $api->get('me', 'App\Http\Controllers\Auth\AuthController@me');
    $api->get('refresh', 'App\Http\Controllers\Auth\AuthController@refresh');

    $api->post('login22', ['middleware' => 'api.throttle', 'limit' => 1, 'expires' => 1,'uses' => 'App\Http\Controllers\Auth\AuthController@login']);





});

$api->version('v2', function ($api) use ($router) {
    $api->get('/a', function () use ($api,$router) {
        return 'hello';
    });
});