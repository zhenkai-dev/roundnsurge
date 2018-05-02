<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 18/3/2018
 * Time: 10:28 AM
 */

namespace App\Enumeration;


class LinkTargetEnum
{
    const SELF = '_self';
    const BLANK = '_blank';

    public static function values(): array
    {
        return [self::SELF, self::BLANK];
    }
}