<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 13/5/2017
 * Time: 4:17 PM
 */

namespace App\Service\Query;

use App\Service\Admin\Util\PageSizeUtil;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PaginateTrait
{
    /**
     * Build pagination
     *
     * @param Builder $query
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function buildPagination(Builder $query, Request $request): LengthAwarePaginator
    {
        /* @var $result LengthAwarePaginator */
        $result = $query->paginate(PageSizeUtil::getPageSize());

        foreach ($request->all() as $key => $list) {
            $result->appends($key, $list);
        }

        return $result;
    }
}