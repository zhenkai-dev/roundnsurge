<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 8/1/2018
 * Time: 8:35 AM
 */

namespace App\Service\Util;

use Illuminate\View\View;

class SortUtil
{
    public const SORT_ICON_CLASS = 'fa fa-sort';
    public const SORT_ASC_CLASS = ' fa fa-sort-asc';
    public const SORT_DESC_CLASS = 'fa fa-sort-desc';

    public const SORT_DIRECTION_ASC = 'asc';
    public const SORT_DIRECTION_DESC = 'desc';

    /**
     * Get sortable link by given column name, attach with current url request.
     * Sort direction default to asc, and switch to desc if sort request asc found in url.
     *
     * @param string $sortBy name to be sorted
     * @return string generated sortable link
     */
    public static function link(string $sortBy): string
    {
        $direction = app('ParseSortFromCurrentUrl')->getNextDirection($sortBy);

        $currentQueryList = app('ParseSortFromCurrentUrl')->getQueryList();
        $currentQueryList[] = 'sort=' . $sortBy . ',' . $direction;

        if (!empty($currentQueryList)) {
            $queryString = implode('&', $currentQueryList);
        }

        return app('ParseSortFromCurrentUrl')->getCurrentUrl() . (!empty($queryString) ? '?' . $queryString : '');
    }

    /**
     * Get sortable column header view
     *
     * @param string $sortBy name to be sorted
     * @param string $name column name
     * @return View sortable view
     */
    public static function sortable(string $sortBy, string $name): View
    {
        $link = self::link($sortBy);

        $icon = app('ParseSortFromCurrentUrl')->getSortIcon($sortBy);

        return view('vendor.sortable.default', compact('link', 'name', 'icon'));
    }
}
