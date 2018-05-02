<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 5/4/2018
 * Time: 8:30 AM
 */

namespace App\Repository\Web;


use App\FriendlyUrl;
use App\Menu;
use App\MenuTranslation;
use DB;
use Illuminate\Database\Eloquent\Builder;

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
     * @return Builder
     */
    public static function findAll(): Builder
    {
        return Menu::query()->join(
            MenuTranslation::getTableName(),
            Menu::getTableName() . '.id',
            '=',
            MenuTranslation::getTableName() . '.menu_id'
        )
            ->leftJoin(
                FriendlyUrl::getTableName(),
                Menu::getTableName() . '.url_id',
                '=',
                FriendlyUrl::getTableName() . '.id'
            )
            ->where(MenuTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->where(Menu::getTableName() . '.is_active', '=', true)
            ->orderBy('parent_id', 'asc')
            ->orderBy('ordering', 'asc')
            ->orderBy('id', 'asc')
            ->select([
                Menu::getTableName() . '.*',
                DB::raw(MenuTranslation::getTableName() . '.name as menu_name'),
                DB::raw(FriendlyUrl::getTableName() . '.id as friendly_url_id'),
                DB::raw(FriendlyUrl::getTableName() . '.name as friendly_url_name'),
                DB::raw(FriendlyUrl::getTableName() . '.module as friendly_url_module'),
            ]);
    }
}