<?php

namespace Src\Services;

use Src\Models\Product;

class InventoryService
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
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
            throw new \Exception("Insufficient stock");
        }

        return $this->productModel->reduceStock($productId, $quantity);
    }

    public function getLowStockProducts(): array
    {
        $products = $this->productModel->getAll();

        return array_filter($products, function ($product) {
            return $product['stock_qty'] <= $product['low_threshold'];
        });
    }
}
