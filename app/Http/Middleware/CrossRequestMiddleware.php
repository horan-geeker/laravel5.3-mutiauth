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
	    $response = $next($request);
	    $response->header('Access-Control-Allow-Origin', "*");
	    $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
	    $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
	    $response->header('Access-Control-Allow-Credentials', 'true');
	    return $response;
    }
}