<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 18/3/2018
 * Time: 10:43 AM
 */

namespace App\Repository\Admin;

use App\FriendlyUrl;
use App\News;
use App\NewsTranslation;
use App\Page;
use App\PageTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class FriendlyUrlRepository extends Repository
{
    /**
     * @return Builder
     */
    public static function getPages(): Builder
    {
        return FriendlyUrl::query()->join(Page::getTableName(), function (JoinClause $join) {
            $join->on(FriendlyUrl::getTableName() . '.fkid', '=', Page::getTableName() . '.id')
                ->where(FriendlyUrl::getTableName() . '.module', '=', 'App\Page');
        })->join(
            PageTranslation::getTableName(),
            PageTranslation::getTableName() . '.page_id',
            Page::getTableName() . '.id'
        )
        ->where('is_module', '=', false)
        ->orderBy(PageTranslation::getTableName() . '.name', 'asc')
        ->select([
            FriendlyUrl::getTableName() . '.id',
            FriendlyUrl::getTableName() . '.module',
            PageTranslation::getTableName() . '.name'
        ]);
    }

    /**
     * @return Builder
     */
    public static function getNews(): Builder
    {
        return FriendlyUrl::query()->join(News::getTableName(), function (JoinClause $join) {
            $join->on(FriendlyUrl::getTableName() . '.fkid', '=', News::getTableName() . '.id')
                ->where(FriendlyUrl::getTableName() . '.module', '=', 'App\News');
        })->join(
            NewsTranslation::getTableName(),
            NewsTranslation::getTableName() . '.news_id',
            News::getTableName() . '.id'
        )
            ->orderBy(NewsTranslation::getTableName() . '.name', 'asc')
            ->select([
                FriendlyUrl::getTableName() . '.id',
                FriendlyUrl::getTableName() . '.module',
                NewsTranslation::getTableName() . '.name'
            ]);
    }
}