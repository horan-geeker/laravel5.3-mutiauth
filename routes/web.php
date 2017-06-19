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
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'pjax',
], function ($route) {
    Auth::routes();

    $route->get('/', 'HomeController@index');
    $route->resource('managers', 'ManagerController');
    $route->resource('users', 'UserController');
    $route->resource('schedules', 'ScheduleController');
});

/*
 * 前端路由，由 vue-router 处理路由
 */

Route::any('/{catchall?}', function () {
    return view('web/app');
})->where('catchall', '(.*)');
