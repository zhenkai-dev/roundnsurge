<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 13/5/2017
 * Time: 4:17 PM
 */

namespace App\Service\Query;

trait FilterTrait
{
    /**
     * Filterable array list
     *
     * @var array
     */
    private $filterableList = array();

    /**
     * Build condition
     */
    private function buildCondition(): void
    {
        if (!empty($this->getFilterableList())) {
            foreach ($this->getFilterableList() as $key => $condition) {
                $condition();
            }
        }
    }

    /**
     * @return array
     */
    public function getFilterableList(): array
    {
        return $this->filterableList;
    }

    /**
     * @param array $filterableList
     */
    public function setFilterableList(array $filterableList)
    {
        $this->filterableList = $filterableList;
    }
}