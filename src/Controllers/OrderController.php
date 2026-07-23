<?php

namespace Src\Controllers;

use Src\Models\Order;
use Src\Services\OrderService;

class OrderController
{
    private OrderService $orderService;
    private Order $orderModel;


    public function __construct(
        OrderService $orderService,
        Order $orderModel
    ) {
        $this->orderService = $orderService;
        $this->orderModel = $orderModel;
    }


    public function createOrder()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );


        return $this->orderService->createOrder($data);
    }



    public function getOrders()
    {
        return $this->orderModel->getAll();
    }
}