<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Tools;
use App\Modules\Auth\UserModules;
use App\Modules\Perm\PermModules;
use Closure;
use CustomAuth;
use Route;

class Privilege
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
        if (! PermModules::check(Tools::getCurrentRoute())) {
            if ($request->ajax()) {
                return response('No Privilege.', 403);
            } else {
                abort(403, 'No Privilege.');
            }
        }

        return $next($request);
    }
}
