<?php

namespace App\Http\Middleware;

use App\Modules\Auth\UserModules;
use Closure;
use CustomAuth;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
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
