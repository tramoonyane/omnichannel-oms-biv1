<?php

namespace Src\Services;

use Src\Core\Database;
use Src\Models\Order;
use Src\Models\Product;
use Src\Services\InventoryService;

class OrderService
{
    private $db;
    private Order $orderModel;
    private InventoryService $inventoryService;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();

        $this->orderModel = new Order();
        $this->inventoryService = new InventoryService();
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

                // 🔥 ALL inventory logic now delegated
                $product = $this->inventoryService->getProductById($productId);

                if (!$product) {
                    throw new \Exception("Product not found");
                }

                // stock validation + deduction handled inside InventoryService
                $this->inventoryService->reduceStock($productId, $quantity);

                // add order item
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
