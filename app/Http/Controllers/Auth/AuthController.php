<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 2019/1/10
 * Time: 上午11:48
 */

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\JWTException;

use Dingo\Api\Routing\Helpers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;



class AuthController extends BaseController
{
    use Helpers;

    protected $request;

    public function __construct(Request $request,JWTAuth $jwt)
    {
        $this->request = $request;
        $this->middleware('refresh', ['except' => ['login']]);
    }


    /**
     * 登录
     * @return mixed
     * @throws \ErrorException
     */
    public function login()
    {

        //获取指定字段
        $account_field = $this->request->only('email','password');


        try {
            //调用auth 中的api
//            $token = Auth::guard('api')->attempt($account_field); //以下方法也可以

            $token =JWTAuth::attempt($account_field);

            if(!$token) {
                return $this->response->array(['status' => 400,'msg' => '账号或密码不对'])->setStatusCode(400);
            }

        }  catch (JWTException $e) {
            return $this->response->array(['status' => 501,'msg' => $e->getMessage()])->setStatusCode(501);
        }

        return $this->response->array(['status' => 200,'msg' => 'success','data' => ['signature' => $token]])->setStatusCode(200);

    }


    public function me()
    {


        try {

        } catch (JWTException $exception) {
            dd(333);
            return $this->response->array(['status' => 400,'msg' => '账号或密码不对'])->setStatusCode(400);

        }
        throw new UnauthorizedHttpException('777', '999');

        return response()->json(JWTAuth::parseToken()->touser());
    }


}