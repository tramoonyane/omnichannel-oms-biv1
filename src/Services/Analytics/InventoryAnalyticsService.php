<?php

namespace Src\Services\Analytics;

use Src\Models\Product;

class InventoryAnalyticsService
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getInventoryOverview(): array
    {
        $products = $this->productModel->getAll();

        $totalProducts = count($products);
        $totalStockValue = 0;

        foreach ($products as $product) {
            $totalStockValue += $product['price'] * $product['stock_qty'];
        }

        return [
            "total_products" => $totalProducts,
            "total_stock_value" => $totalStockValue
        ];
    }

    public function getLowStockProducts(): array
    {
        $products = $this->productModel->getAll();

        return array_values(array_filter($products, function ($p) {
            return $p['stock_qty'] <= $p['low_threshold'];
        }));
    }

    public function getHighStockProducts(): array
    {
        $products = $this->productModel->getAll();

        return array_values(array_filter($products, function ($p) {
            return $p['stock_qty'] > $p['low_threshold'];
        }));
    }
}