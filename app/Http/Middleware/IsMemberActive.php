<?php

namespace App\Http\Middleware;

use Closure;

class IsMemberActive
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
        if ($request->user() && $request->route()->getPrefix() == 'rs-member') {
            if (!$request->user()->is_active) abort(404);
        }

        return $next($request);
    }
}
