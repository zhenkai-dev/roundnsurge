<?php

namespace App\Repository\Member;

use App\Banner;
use App\BannerTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BannerRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Banner';
    }

    /**
     * Find listing
     *
     * @param Request $request
     * @return Builder
     */
    public function findListing(Request $request): Builder
    {
        $query = Banner::query()->join(
            BannerTranslation::getTableName(),
            Banner::getTableName() . '.id',
            '=',
            BannerTranslation::getTableName() . '.banner_id'
        )->where(BannerTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->orderBy('ordering', 'asc')
            ->orderBy('id', 'asc');
        return $this->selectColumnFromListing($query);
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
            Banner::getTableName() . '.*'
        ]);
    }
}
