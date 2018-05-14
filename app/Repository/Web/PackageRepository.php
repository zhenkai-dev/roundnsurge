<?php

namespace App\Repository\Web;

use App\Package;
use App\PackageTranslation;
use DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 14/5/2018
 * Time: 11:03 AM
 */
class PackageRepository extends Repository
{
    /**
     * Find all
     *
     * @return Builder
     */
    public static function findAll(): Builder
    {
        return Package::query()->join(
            PackageTranslation::getTableName(),
            Package::getTableName() . '.id',
            '=',
            PackageTranslation::getTableName() . '.package_id'
        )->where(PackageTranslation::getTableName() . '.language_id', '=', app('Language')->getId())
            ->where('is_active', '=', true)
            ->orderBy('price', 'asc')
            ->select([
                Package::getTableName() . '.*',
                DB::raw(PackageTranslation::getTableName() . '.name as package_name'),
                DB::raw(PackageTranslation::getTableName() . '.description as package_description')
            ]);
    }
}