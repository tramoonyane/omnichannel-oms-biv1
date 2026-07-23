<?php

namespace Src\Services;

use PDO;
use Src\Models\Order;
use Src\Services\InventoryService;

class OrderService
{
    private PDO $db;
    private Order $orderModel;
    private InventoryService $inventoryService;

    // 💡 Pass the dependencies through the constructor. 
    // Slim 4's Container will automatically resolve and inject these for you.
    public function __construct(PDO $db, Order $orderModel, InventoryService $inventoryService)
    {
        $this->db = $db;
        $this->orderModel = $orderModel;
        $this->inventoryService = $inventoryService;
    }

    public function createOrder(array $data): array
    {
        if (!isset($data['items']) || empty($data['items'])) {
            return [
                "error" => "Order must contain items"
            ];
        }

        $this->db->beginTransaction();

        try {
            // 1. Create order header
            $orderId = $this->orderModel->create([
                'customer_name' => $data['customer_name'] ?? 'Guest',
                'status' => 'pending'
            ]);

            // 2. Process items
            foreach ($data['items'] as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];

                // All inventory logic delegated to the injected service
                $product = $this->inventoryService->getProductById($productId);

                if (!$product) {
                    throw new \Exception("Product not found");
                }

                // Stock validation + deduction handled inside InventoryService
                $this->inventoryService->reduceStock($productId, $quantity);

                // Add order item details
                $this->orderModel->addItem([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price_at_sale' => $product['price']
                ]);
            }

            $this->db->commit();

            return [
                "message" => "Order created successfully",
                "order_id" => $orderId
            ];

        } catch (\Exception $e) {
            $this->db->rollBack();

            return [
                "error" => $e->getMessage()
            ];
        }
    }
}
