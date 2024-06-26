<?php

namespace App\Repository\Member;

use App\Course;
use App\CourseTranslation;
use App\Member;
use App\Package;
use App\Service\Query\FilterTrait;
use App\Service\Query\PaginateTrait;
use App\Service\Query\SortTrait;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

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
        $member = Member::find(Auth::id());
        /* @var Member $member */
        $package = $member->allowPackageToViewCourse();
        // dd(explode(',', $package->allowed_package_id));

        $query = Course::query()->join(
            CourseTranslation::getTableName(),
            Course::getTableName() . '.id',
            '=',
            CourseTranslation::getTableName() . '.course_id'
        )->join('course_packages', 'course_packages.course_id', '=', Course::getTableName() . '.id')
        ->where(Course::getTableName() . '.is_active', true)
        ->where(CourseTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
        ->whereIn('course_packages.package_id', explode(',', $package->allowed_package_id))
        ->groupBy('course_packages.course_id');
        // ->where('course_packages.package_id', '=', $package->getId());

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

    public function verifyMplusUser()
    {
        $isPOV = DB::table('memberships')
                    ->where([
                        ['member_id', '=', Auth::id()],
                        ['package_id', '=', 1],
                        ['is_active', '=', 1],
                    ])
                    ->count();
        if($isPOV > 0) {
            return true;
        }
        return false;
    }
}
