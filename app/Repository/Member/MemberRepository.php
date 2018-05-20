<?php

namespace App\Repository\Member;

use App\Service\Query\FilterTrait;
use App\Service\Query\PaginateTrait;
use App\Service\Query\SortTrait;
use App\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberRepository extends Repository
{
    use SortTrait;
    use FilterTrait;
    use PaginateTrait;

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Member';
    }

    /**
     * Find listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function findListing(Request $request): LengthAwarePaginator
    {
        $query = Member::query();

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
                $query->where(Member::getTableName() . '.name', 'like', '%' . $request->input($key) . '%');
            }
            return $query;
        };

        $this->filterableList[] = function (string $key = 'mobile') use ($query, $request): Builder {
            if ($request->filled($key)) {
                return $query->where(
                    Member::getTableName() . '.mobile',
                    'like',
                    '%' . $request->input($key) . '%'
                );
            }
            return $query;
        };

        $this->filterableList[] = function (string $key = 'email') use ($query, $request): Builder {
            if ($request->filled($key)) {
                return $query->where(
                    Member::getTableName() . '.email',
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
            'id' => Member::getTableName() . '.id',
            'name' => Member::getTableName() . '.name',
            'mobile' => Member::getTableName() . '.mobile',
            'email' => Member::getTableName() . '.email'
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
            Member::getTableName() . '.*'
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
