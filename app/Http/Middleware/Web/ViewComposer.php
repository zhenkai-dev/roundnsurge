<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 5/4/2018
 * Time: 8:19 AM
 */

namespace App\Http\Middleware\Web;

use App\Service\Web\MenuService;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ViewComposer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //load header
        View::composer('web.layouts.app', function ($view) {
            /* @var \Illuminate\View\View $view */
            $menuGrouped = [];
            $menuAll = MenuService::getAll();
            if (count($menuAll)) {
                foreach ($menuAll as $menu) {
                    /* @var \App\Menu $menu */
                    $menuGrouped[(is_null($menu->getParentId()) ? 0 : $menu->getParentId())][] = $menu;
                }
            }

            $view->with(compact('menuGrouped'));
        });

        return $next($request);
    }
}