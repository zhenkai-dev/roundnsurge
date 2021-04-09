<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 6/1/2018
 * Time: 6:22 PM
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == config('auth.guards.web.name')) {
            if (Auth::guard($guard)->check()) {
                if ($request->route()->getName() == 'web.register' && $request->has('package')) {
                    return redirect(route('member.account.membership'));
                }
                return redirect(route('member.home'));
            }
        } elseif ($guard == config('auth.guards.admin.name')) {
            if (Auth::guard($guard)->check()) {
                return redirect(route('admin.home'));
            }
        }

        return $next($request);
    }
}
