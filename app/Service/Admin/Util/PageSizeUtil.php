<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 1:44 AM
 */

namespace App\Service\Admin\Util;

class PageSizeUtil
{
    public const PAGE_SIZE_NAME = 'adminPageSize';

    public const EXPIRATION = '2 weeks';

    /**
     * Get available option list for page size
     *
     * @return array
     */
    public static function getPageSizeList()
    {
        return [20, 50, 100, 250, 500];
    }

    /**
     * @return int
     */
    public static function getPageSize(): int
    {
        return (int) (!empty(request()->cookie(self::PAGE_SIZE_NAME)) ?
            request()->cookie(self::PAGE_SIZE_NAME) :
            self::getPageSizeList()[0]);
    }
}