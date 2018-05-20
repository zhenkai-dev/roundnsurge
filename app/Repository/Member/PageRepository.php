<?php

namespace App\Repository\Member;

use App\Page;
use App\PageTranslation;
use App\Service\Query\FilterTrait;
use App\Service\Query\PaginateTrait;
use App\Service\Query\SortTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PageRepository extends Repository
{
    use SortTrait;
    use FilterTrait;
    use PaginateTrait;

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Page';
    }

    /**
     * Find listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function findListing(Request $request): LengthAwarePaginator
    {
        $query = Page::query()->join(
            PageTranslation::getTableName(),
            Page::getTableName() . '.id',
            '=',
            PageTranslation::getTableName() . '.page_id'
        )->where(PageTranslation::getTableName() . '.language_id', '=', app('Language')->getId());

        $query = $this->filterListing($query, $request);
        $query = $this->sortListing($query);
        $query = $this->selectColumnFromListing($query);

        return $this->paginateListing($query, $request);
    }

    /**
     * Filter listing
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    private function filterListing(Builder $query, Request $request): Builder
    {
        $this->filterableList[] = function (string $key = 'name') use ($query, $request): Builder {
            if ($request->filled($key)) {
                $query->where(
                    PageTranslation::getTableName() . '.name',
                    'like',
                    '%' . $request->input($key) . '%'
                );
            }
            return $query;
        };

        $this->filterableList[] = function (string $key = 'pagename') use ($query, $request): Builder {
            if ($request->filled($key)) {
                return $query->where(
                    Page::getTableName() . '.pagename',
                    'like',
                    '%' . $request->input($key) . '%'
                );
            }
            return $query;
        };

        $this->filterableList[] = function (string $key = 'email') use ($query, $request): Builder {
            if ($request->filled($key)) {
                return $query->where(
                    Page::getTableName() . '.email',
                    'like',
                    '%' . $request->input($key) . '%'
                );
            }
            return $query;
        };

        $this->buildCondition();

        return $query;
    }

    /**
     * Sort listing
     *
     * @param Builder $query
     * @return Builder
     */
    private function sortListing(Builder $query): Builder
    {
        $this->sortableList = [
            'id' => Page::getTableName() . '.id',
            'name' => PageTranslation::getTableName() . '.name'
        ];

        return $this->buildSorting($query, $this->sortableList);
    }

    /**
     * Select listing column
     *
     * @param Builder $query
     * @return Builder
     */
    private function selectColumnFromListing(Builder $query): Builder
    {
        return $query->select([
            Page::getTableName() . '.*'
        ]);
    }

    /**
     * Paginate listing
     *
     * @param Builder $query
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function paginateListing(Builder $query, Request $request): LengthAwarePaginator
    {
        return $this->buildPagination($query, $request);
    }
}
