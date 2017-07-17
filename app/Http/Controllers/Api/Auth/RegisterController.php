<?php

namespace App\Http\Controllers\Api\Auth;

use App\Jobs\SendEmail;
use App\Mail\UserNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 1,
                'msg' => $validator->errors(),
            ]);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        $job = new SendEmail(\Auth::user()->email, new UserNotify('success',['恭喜你注册成功']));
        dispatch($job);

        return response()->json([
            'status' => 0,
            'msg' => 'register success',
            'data' => \Auth::user()
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
