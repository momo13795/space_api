<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

 $app->withFacades();

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

//引入config
$app->configure('dingo');
//$app->configure('jwt');
$app->configure('auth');


$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

 $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
     'refresh' => App\Http\Middleware\RefreshToken::class,
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

 $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
 $app->register(App\Providers\EventServiceProvider::class);

$app->register(Dingo\Api\Provider\LumenServiceProvider::class);//注册dingo 服务
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);//注册jwt 服务


//app('Dingo\Api\Exception\Handler')->register(function (Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception) {
////   return  response()->json(['error' => '90900'],403);
//        dd($exception);
//    if ($exception instanceof UnauthorizedHttpException) {
//
//        // detect previous instance
//        if ($exception->getPrevious() instanceof TokenExpiredException) {
//            return response()->json(['error' => 'TOKEN_EXPIRED'], $exception->getStatusCode());
//        } else if ($exception->getPrevious() instanceof TokenInvalidException) {
//            return response()->json(['error' => 'TOKEN_INVALID'], $exception->getStatusCode());
//        } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
//            return response()->json(['error' => 'TOKEN_BLACKLISTED'], $exception->getStatusCode());
//        } else {
//            return response()->json(['error' => "UNAUTHORIZED_REQUEST"], 401);
//        }
//    }
//
//    return  response()->json(['error' => '90901'],403);
//
//
//
//});

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
    require __DIR__.'/../routes/api.php';
});

return $app;
