<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 2019/1/10
 * Time: 上午11:48
 */

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Routing\Helpers;

use Laravel\Lumen\Routing\Controller as BaseController;




class AuthController extends BaseController
{
    use Helpers;

    protected $request;

    public function __construct(Request $request,JWTAuth $jwt)
    {
        $this->request = $request;
        $this->middleware('jwt.auth', ['except' => ['login','refresh','register']]);
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


    public function register()
    {
        $this->validate($this->request, [
            'email'     => 'required',
            'password'  => 'min:6|max:20',
            'equipment_number' => 'required',
            'displayname' => 'required|min:3|max:30',
            'nickname'     => 'required',
        ]);
    }





    public function me()
    {
        return response()->json(JWTAuth::parseToken()->touser());
    }


    /**
     * 退出删除token
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     *
     * 刷新token,刷新一次上个token将会失效
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }



}