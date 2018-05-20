<?php

namespace App\Repository\Admin;

use App\Course;
use App\CourseTranslation;
use App\Service\Query\FilterTrait;
use App\Service\Query\PaginateTrait;
use App\Service\Query\SortTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository extends Repository
{
    use SortTrait;
    use FilterTrait;
    use PaginateTrait;

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Course';
    }

    /**
     * Find listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function findListing(Request $request): LengthAwarePaginator
    {
        $query = Course::query()->join(
            CourseTranslation::getTableName(),
            Course::getTableName() . '.id',
            '=',
            CourseTranslation::getTableName() . '.course_id'
        )->where(CourseTranslation::getTableName() . '.language_id', '=', app('Language')->getId());

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
                    CourseTranslation::getTableName() . '.name',
                    'like',
                    '%' . $request->input($key) . '%'
                );
            }
            return $query;
        };

        $this->filterableList[] = function (string $key = 'packages') use ($query, $request): Builder {
            if ($request->filled($key)) {

                $packageJoin = 'or';
                if ($request->filled('package_join')) {
                    switch ($request->input('package_join')) {
                        case 'and':
                            $packageJoin = $request->input('package_join');
                            break;
                        default:
                    }
                }

                switch ($packageJoin) {
                    case 'and':
                        $query->whereIn(Course::getTableName() . '.id', function (\Illuminate\Database\Query\Builder $q) use ($request, $key) {
                            $q->select('course_id')
                                ->from('course_packages')
                                ->whereIn('package_id', $request->input($key))
                                ->groupBy('course_id')
                                ->havingRaw('count(distinct package_id) = ' . count($request->input($key)));
                        });
                        break;
                    default:
                        $query->whereIn(Course::getTableName() . '.id', function (\Illuminate\Database\Query\Builder $q) use ($request, $key) {
                            $q->select('course_id')
                                ->from('course_packages')
                                ->whereIn('package_id', $request->input($key));
                        });

                }
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
            'id' => Course::getTableName() . '.id',
            'name' => CourseTranslation::getTableName() . '.name'
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
            Course::getTableName() . '.*'
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
