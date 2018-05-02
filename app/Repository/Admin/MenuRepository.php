<?php

namespace App\Repository\Admin;

use App\FriendlyUrl;
use App\Menu;
use App\MenuTranslation;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MenuRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Menu';
    }

    /**
     * Find listing
     *
     * @param Request $request
     * @return Builder
     */
    public function findListing(Request $request): Builder
    {
        $query = Menu::query()->join(
            MenuTranslation::getTableName(),
            Menu::getTableName() . '.id',
            '=',
            MenuTranslation::getTableName() . '.menu_id'
        )
            /*->leftJoin(
                FriendlyUrl::getTableName(),
                Menu::getTableName() . '.url_id',
                '=',
                FriendlyUrl::getTableName() . '.fkid'
            )*/
            ->where(MenuTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->orderBy('parent_id', 'asc')
            ->orderBy('ordering', 'asc')
            ->orderBy('id', 'asc');

        $query = $this->selectColumnFromListing($query);

        //return $this->paginateListing($query, $request);
        return $query;
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
            Menu::getTableName() . '.*',
            // DB::raw(FriendlyUrl::getTableName() . '.name as friendly_url_name'),
        ]);
    }
}
