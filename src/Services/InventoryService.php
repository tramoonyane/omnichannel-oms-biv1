<?php

namespace Src\Services;

use Src\Models\Product;

class InventoryService
{
    private Product $productModel;

    // 💡 Dependency Injection: We inject the pre-configured model from the outside.
    // This ensures it shares the same single PDO database handle as everything else.
    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function getAllProducts(): array
    {
        return $this->productModel->getAll();
    }

    public function getProductById(int $id): ?array
    {
        return $this->productModel->find($id);
    }

    public function reduceStock(int $productId, int $quantity): bool
    {
        $product = $this->productModel->find($productId);

        if (!$product) {
            throw new \Exception("Product not found");
        }

        if ($product['stock_qty'] < $quantity) {
            throw new \Exception("Insufficient stock for product: " . $product['name']);
        }

        return $this->productModel->reduceStock($productId, $quantity);
    }

    /**
     * Highly optimized memory handling for business intelligence alerts
     */
    public function getLowStockProducts(): array
    {
        // 💡 Instead of fetching everything and using array_filter in PHP,
        // we delegate the filtering entirely to a dedicated MySQL query.
        return $this->productModel->getLowStock();
    }
}
