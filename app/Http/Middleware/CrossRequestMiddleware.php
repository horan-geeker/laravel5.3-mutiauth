<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CrossRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        header('Access-Control-Allow-Origin: ' . config('app.domain'));
//        header('Access-Control-Allow-Methods: ' . 'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
//        header('Access-Control-Allow-Headers: ' . 'Content-Type, Accept, Cookie, X-Requested-With');
//        header('Access-Control-Allow-Credentials: ' . 'true');

        return $next($request);
    }
}