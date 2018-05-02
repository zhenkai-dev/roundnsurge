<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 13/5/2017
 * Time: 4:17 PM
 */

namespace App\Service\Query;

use App\Service\ParseSortFromCurrentUrl;
use App\Service\Util\SortUtil;
use Illuminate\Database\Eloquent\Builder;

trait SortTrait
{
    /**
     * Sortable array list
     *
     * @var array
     */
    private $sortableList = [];

    /**
     * @var ParseSortFromCurrentUrl $parseSortFromCurrentUrl
     */
    private $parseSortFromCurrentUrl;

    public function __construct()
    {
        $this->parseSortFromCurrentUrl = app('ParseSortFromCurrentUrl');
    }

    /**
     * Build sorting name
     *
     * @return string
     */
    private function buildSortName(): string
    {
        $sortRequestName = $this->parseSortFromCurrentUrl->getSortRequestName();

        if (array_key_exists($sortRequestName, $this->sortableList)) {
            return $this->sortableList[$sortRequestName];
        }

        return array_shift($this->sortableList);
    }

    /**
     * Build sort direction
     *
     * @return string
     */
    private function buildSortDirection(): string
    {
        $sortList = array(
            SortUtil::SORT_DIRECTION_ASC, SortUtil::SORT_DIRECTION_DESC
        );

        $sortRequestDirection = $this->parseSortFromCurrentUrl->getSortRequestDirection();

        if (in_array($sortRequestDirection, $sortList)) {
            return $sortRequestDirection;
        }

        return SortUtil::SORT_DIRECTION_DESC;
    }

    /**
     * @return array
     */
    public function getSortableList(): array
    {
        return $this->sortableList;
    }

    /**
     * @param array $sortableList
     */
    public function setSortableList(array $sortableList): void
    {
        $this->sortableList = $sortableList;
    }

    /**
     * @param Builder $query
     * @param array   $sortableList
     * @return Builder
     */
    public function buildSorting(Builder $query, array $sortableList): Builder
    {
        if (!empty($sortableList)) {
            $query->orderBy($this->buildSortName(), $this->buildSortDirection());
        }
        return $query;
    }
}
