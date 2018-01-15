<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*
 * 管理员端路由
 */


Route::group([
    'namespace' => 'Admin',
    'middleware' => 'pjax',
], function () {
    Auth::routes();
    Route::group([
        'middleware' => 'auth.admin:admin'
    ],function ($route){
        $route->get('/', 'HomeController@index');
        $route->resource('managers', 'ManagerController');
        $route->resource('users', 'UserController');
        $route->resource('schedules', 'ScheduleController');
        $route->resource('posts', 'PostController');
    });
    Route::get('/test/email-view',function (){
        return view('emails.users.notify',[
            'level'=>'success',
            'introLines'=>['恭喜你注册成功'],
            'outroLines'=>['感谢您对我们的支持，此邮件请勿回复']
        ]);
    });
});

/*
 * 前端路由，由 vue-router 处理路由
 */

//Route::any('/{catchall?}', function () {
//    return view('web/app');
//})->where('catchall', '(.*)');
