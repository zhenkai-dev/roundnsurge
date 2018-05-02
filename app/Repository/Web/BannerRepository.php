<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 14/4/2018
 * Time: 7:37 PM
 */

namespace App\Repository\Web;


use App\Banner;
use App\BannerTranslation;
use App\FriendlyUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BannerRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Banner';
    }

    public static function findAll(): Builder
    {
        return Banner::query()->join(
            BannerTranslation::getTableName(),
            Banner::getTableName() . '.id',
            '=',
            BannerTranslation::getTableName() . '.banner_id'
        )
            ->leftJoin(
                FriendlyUrl::getTableName(),
                Banner::getTableName() . '.url_id',
                '=',
                FriendlyUrl::getTableName() . '.id'
            )
            ->where(BannerTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->where(Banner::getTableName() . '.is_active', '=', true)
            ->orderBy('ordering', 'asc')
            ->orderBy('id', 'asc')
            ->select([
                Banner::getTableName() . '.*',
                DB::raw(BannerTranslation::getTableName() . '.name as banner_name'),
                DB::raw(BannerTranslation::getTableName() . '.description as banner_description'),
                DB::raw(FriendlyUrl::getTableName() . '.id as friendly_url_id'),
                DB::raw(FriendlyUrl::getTableName() . '.name as friendly_url_name'),
                DB::raw(FriendlyUrl::getTableName() . '.module as friendly_url_module'),
            ]);
    }
}