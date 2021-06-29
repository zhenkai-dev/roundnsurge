<?php

namespace App\Service\Admin;

use App\Repository\Admin\OrderRepository;
use Illuminate\Http\Request;

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public static function getOrderList(): array
    {
        $upgradeOrders = OrderRepository::getUpgradeOrders()->get()->toArray();

        $registerOrders = OrderRepository::getRegisterOrders()->get()->toArray();

        return ['upgrade_orders' => $upgradeOrders, 'register_orders' => $registerOrders];
    }
}