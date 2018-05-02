<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/1/2018
 * Time: 2:21 AM
 */

namespace App\Service;

use App\Service\Util\SortUtil;
use Illuminate\Support\Facades\URL;

class ParseSortFromCurrentUrl
{
    private $currentUrl;
    private $sortRequestName;
    private $sortRequestDirection;
    private $queryList = [];

    public function __construct()
    {
        //get query list in array
        $request = request()->all();
        foreach ($request as $key => $value) {
            if ($key != 'sort' && !is_array($value) && $value != '') {
                $this->queryList[] = $key . '=' . $value;
            }
        }

        //get sort name and direction from sort request
        $sortRequest = request('sort');
        if (!empty($sortRequest)) {
            $sortRequestList = explode(',', $sortRequest);
            if (count($sortRequestList) == 2) {
                $this->sortRequestName = $sortRequestList[0];
                $this->sortRequestDirection = $sortRequestList[1];
            }
        }

        //get current url
        $this->currentUrl = URL::current();
    }

    /**
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->currentUrl;
    }

    /**
     * @return array
     */
    public function getQueryList(): array
    {
        return $this->queryList;
    }

    public function getSortRequestName(): ?string
    {
        return $this->sortRequestName;
    }

    public function getSortRequestDirection(): ?string
    {
        return $this->sortRequestDirection;
    }

    /**
     * Get next sort direction depends on 'sort' parameter in current url.
     * If sort = asc, return desc, and vice versa
     *
     * @param string $sortBy name to be sorted
     * @return string new direction
     */
    public function getNextDirection(string $sortBy): string
    {
        $direction = SortUtil::SORT_DIRECTION_ASC;

        if ($this->sortRequestName == $sortBy && $this->sortRequestDirection == SortUtil::SORT_DIRECTION_ASC) {
            $direction = SortUtil::SORT_DIRECTION_DESC;
        }

        return $direction;
    }

    /**
     * Get sort icon by column
     *
     * @param string $sortBy name to be sorted
     * @return string sort icon
     */
    public function getSortIcon(string $sortBy): string
    {
        $icon = SortUtil::SORT_ICON_CLASS;

        if ($this->sortRequestName == $sortBy) {
            if ($this->sortRequestDirection == SortUtil::SORT_DIRECTION_ASC) {
                $icon = SortUtil::SORT_ASC_CLASS;
            } elseif ($this->sortRequestDirection == SortUtil::SORT_DIRECTION_DESC) {
                $icon = SortUtil::SORT_DESC_CLASS;
            }
        }

        return $icon;
    }
}