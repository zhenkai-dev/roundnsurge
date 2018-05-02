<?php

namespace App\Repository\Admin;

use App\Service\Query\FilterTrait;
use App\Service\Query\PaginateTrait;
use App\Service\Query\SortTrait;
use App\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SettingRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Setting';
    }
}
