<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    //接管dingo异常类，重新启用框架字带的异常类
    public function boot()
    {
//        app('api.exception')->register(function (\Exception $exception) {
//            $request = Request::capture();
//            return app('App\Exceptions\Handler')->render($request, $exception);
//        });


    }
}
