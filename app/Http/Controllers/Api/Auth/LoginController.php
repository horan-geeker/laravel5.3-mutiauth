<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 1,
                'msg' => 'email or password empty',
            ]);
        }

        if($this->attemptLogin($request)){
            return response()->json([
                'status'=>0,
                'msg'=>'login success'
            ]);
        }else{
            return response()->json([
                'status'=> 2,
                'msg' => 'email or password error',
            ]);
        }

    }
}
