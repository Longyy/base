<?php

namespace App\Http\Middleware;

use App\Modules\Auth\UserModules;
use Closure;
use CustomAuth;

class Authenticate
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (CustomAuth::guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(UserModules::getHomeUrl());
            }
        }

        return $next($request);
    }
}
