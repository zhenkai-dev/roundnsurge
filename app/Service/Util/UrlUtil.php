<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 15/4/2018
 * Time: 2:48 PM
 */

namespace App\Service\Util;


use App\Dto\UrlDto;
use App\News;
use App\Page;

class UrlUtil
{
    public static function generateSiteUrl(UrlDto $urlDto): string
    {
        if ($urlDto->getFriendlyUrlId() == 1) {
            return url('/');
        }

        if (!empty($urlDto->getFriendlyUrlName())) {
            switch ($urlDto->getFriendlyUrlModule()) {
                case Page::class:
                    return route('web.pages.show', ['slug' => $urlDto->getFriendlyUrlName()]);
                    break;
                case News::class:
                    return route('web.news.show', ['slug' => $urlDto->getFriendlyUrlName()]);
                    break;
                default:
                    return 'javascript:void(0)';
            }
        } elseif (!empty($urlDto->getUrl())) {
            if (is_absolute_url($urlDto->getUrl())) {
                return $urlDto->getUrl();
            } else {
                return url($urlDto->getUrl());
            }
        } else {
            return 'javascript:void(0)';
        }
    }
}