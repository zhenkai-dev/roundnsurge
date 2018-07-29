<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 5:06 PM
 */

namespace App\Repository\Web;


use App\Event;
use App\EventTranslation;
use App\FriendlyUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    /**
     * Find listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function findListing(Request $request): LengthAwarePaginator
    {
        $query = Event::query()->join(
            EventTranslation::getTableName(),
            Event::getTableName() . '.id',
            '=',
            EventTranslation::getTableName() . '.event_id'
        )->leftJoin(
            FriendlyUrl::getTableName(), function (JoinClause $q) {
            $q->on(Event::getTableName() . '.id', '=', FriendlyUrl::getTableName() . '.fkid')
                ->where(FriendlyUrl::getTableName() . '.module', '=', Event::class);
        })->where(EventTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->where(Event::getTableName() . '.is_active', '=', true)
            ->orderBy(Event::getTableName() . '.event_start_at', 'desc')
            ->select([
                Event::getTableName() . '.*',
                DB::raw(EventTranslation::getTableName() . '.name as event_name')
            ]);

        return $query->paginate(10);
    }

    /**
     * @param int $limit
     * @return Builder
     */
    public static function getUpcomingEvents(int $limit = 5): Builder
    {
        $query = Event::query()->join(
            EventTranslation::getTableName(),
            Event::getTableName() . '.id',
            '=',
            EventTranslation::getTableName() . '.event_id'
        )->leftJoin(
            FriendlyUrl::getTableName(), function (JoinClause $q) {
            $q->on(Event::getTableName() . '.id', '=', FriendlyUrl::getTableName() . '.fkid')
                ->where(FriendlyUrl::getTableName() . '.module', '=', Event::class);
        })->where(EventTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->where(Event::getTableName() . '.is_active', '=', true)
            ->orderBy(Event::getTableName() . '.event_start_at', 'desc')
            ->select([
                Event::getTableName() . '.*',
                DB::raw(EventTranslation::getTableName() . '.name as event_name')
            ]);

        return $query->limit($limit);
    }
}