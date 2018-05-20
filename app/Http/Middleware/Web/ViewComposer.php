<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 5/4/2018
 * Time: 8:19 AM
 */

namespace App\Http\Middleware\Web;

use App\FriendlyUrl;
use App\Page;
use App\Service\Web\MenuService;
use Closure;
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
        View::composer('web.layouts.app', function (\Illuminate\View\View $view) {
            $menuGrouped = [];
            $menuAll = MenuService::getAll();
            if (count($menuAll)) {
                foreach ($menuAll as $menu) {
                    /* @var \App\Menu $menu */
                    $menuGrouped[(is_null($menu->getParentId()) ? 0 : $menu->getParentId())][] = $menu;
                }
            }

            $footerPagesAll = Page::whereIn('id', [8, 9])
                ->where('is_active', true)
                ->get();
            $footerPages = [];
            if (count($footerPagesAll)) {
                foreach ($footerPagesAll as $footerPage) {
                    $footerPages[$footerPage->getId()] = $footerPage;
                }
            } 

            $view->with(compact('menuGrouped', 'footerPages'));
        });

        View::composer('web.shared.page-sidebar-component', function (\Illuminate\View\View $view) {
            $sidePanel = Page::where('id', '=', 3)->first();

            $view->with(compact('sidePanel'));
        });

        View::composer('web.auth.register', function (\Illuminate\View\View $view) {
            $registerPage = Page::where('id', '=', 4)->first();

            $termsUrl = FriendlyUrl::where('module', '=', Page::class)
                ->where('fkid', '=', 5)
                ->first();

            $view->with(compact('registerPage', 'termsUrl'));
        });

        return $next($request);
    }
}