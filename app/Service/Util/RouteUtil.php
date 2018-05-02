<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 27/1/2018
 * Time: 11:38 PM
 */

namespace App\Service\Util;


use Illuminate\Support\Facades\Route;

class RouteUtil
{
    /**
     * Get current route type
     *
     * @return string
     */
    public static function routeType(): string
    {
        $route = explode('.', Route::currentRouteName());
        return end($route);
    }
}