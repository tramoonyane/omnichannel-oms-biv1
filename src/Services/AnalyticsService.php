<?php

namespace Src\Services;

use Src\Core\Database;
use Src\Models\Product;
use PDO;

class AnalyticsService
{
    private $db;
    private Product $productModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();

        $this->productModel = new Product();
    }

    /**
     * 1. INVENTORY OVERVIEW
     */
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

    /**
     * 2. LOW STOCK PRODUCTS
     */
    public function getLowStockProducts(): array
    {
        $products = $this->productModel->getAll();

        return array_values(array_filter($products, function ($product) {
            return $product['stock_qty'] <= $product['low_threshold'];
        }));
    }

    /**
     * 3. HIGH STOCK PRODUCTS
     */
    public function getHighStockProducts(): array
    {
        $products = $this->productModel->getAll();

        return array_values(array_filter($products, function ($product) {
            return $product['stock_qty'] > $product['low_threshold'];
        }));
    }

    /**
     * 4. SALES OVERVIEW (KPIs)
     */
    public function getSalesOverview(): array
    {
        $stmt = $this->db->query("
            SELECT
                COUNT(DISTINCT o.id) AS total_orders,
                COALESCE(SUM(oi.quantity * oi.price_at_sale), 0) AS total_revenue
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
        ");

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 5. DAILY SALES TREND
     */
    public function getDailySales(): array
    {
        $stmt = $this->db->query("
            SELECT
                DATE(o.created_at) AS date,
                COUNT(DISTINCT o.id) AS orders,
                COALESCE(SUM(oi.quantity * oi.price_at_sale), 0) AS revenue
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
            GROUP BY DATE(o.created_at)
            ORDER BY date ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 6. TOP SELLING PRODUCTS
     */
    public function getTopProducts(): array
    {
        $stmt = $this->db->query("
            SELECT
                p.id,
                p.title,
                COALESCE(SUM(oi.quantity), 0) AS total_sold,
                COALESCE(SUM(oi.quantity * oi.price_at_sale), 0) AS revenue
            FROM products p
            LEFT JOIN order_items oi ON p.id = oi.product_id
            GROUP BY p.id, p.title
            ORDER BY total_sold DESC
            LIMIT 5
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
