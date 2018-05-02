<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 5:06 PM
 */

namespace App\Repository\Web;


use App\FriendlyUrl;
use App\News;
use App\NewsTranslation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class NewsRepository
{
    /**
     * Find listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function findListing(Request $request): LengthAwarePaginator
    {
        $query = News::query()->join(
            NewsTranslation::getTableName(),
            News::getTableName() . '.id',
            '=',
            NewsTranslation::getTableName() . '.news_id'
        )->leftJoin(
            FriendlyUrl::getTableName(), function (JoinClause $q) {
            $q->on(News::getTableName() . '.id', '=', FriendlyUrl::getTableName() . '.fkid')
                ->where(FriendlyUrl::getTableName() . '.module', '=', News::class);
        })->where(NewsTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->where(News::getTableName() . '.is_active', '=', true)
            ->orderBy(News::getTableName() . '.post_date', 'asc')
            ->select([
                News::getTableName() . '.*',
                DB::raw(NewsTranslation::getTableName() . '.name as news_name'),
                DB::raw(NewsTranslation::getTableName() . '.description as news_description'),
                DB::raw(FriendlyUrl::getTableName() . '.name as friendly_url_name')
            ]);

        return $query->paginate(18);
    }
}