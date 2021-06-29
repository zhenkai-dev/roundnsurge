<?php

namespace App\Repository\Admin;

use App\Order;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'App\Order';
    }

    /**
     * @return Builder
     */
    public static function getUpgradeOrders(): Builder
    {
        return Order::query()->where([['paid', 0], ['order_type', 'upgrade_membership']])->orderBy('created_at', 'DESC')->select([
            'id',
            'order_no',
            'username',
        ]);
    }

    /**
     * @return Builder
     */
    public static function getRegisterOrders(): Builder
    {
        return Order::query()->where([['paid', 0], ['order_type', 'register_membership']])->orderBy('created_at', 'DESC')->select([
            'id',
            'order_no',
            'username',
        ]);
    }
}
