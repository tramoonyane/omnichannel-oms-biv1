<?php

namespace Src\Controllers;

use Src\Models\Order;
use Src\Services\OrderService;

class OrderController
{
    public function createOrder()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $service = new OrderService();

        return $service->createOrder($data);
    }

    public function getOrders()
    {
        $orderModel = new Order();

        return $orderModel->getAll();
    }
}
