<?php

namespace App\Http\Middleware;

use Closure;

class IsMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $flag = app('Setting')->getIsMaintenanceMode();

        if ($flag) {
            abort(503);
        }

        return $next($request);
    }
}
