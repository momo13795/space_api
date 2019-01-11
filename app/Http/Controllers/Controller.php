<?php

namespace App\Http\Controllers;

use App\Model\MemberModel;
use Laravel\Lumen\Routing\Controller as BaseController;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    //

    public function show()
    {


//        dd(JWTAuth::getToken());
        $user = JWTAuth::parseToken()->authenticate();

//        $obj = new MemberModel();
////        dd($obj);
//        $a = $obj->where('id',1)->first();

        dd($user);
    }
}
