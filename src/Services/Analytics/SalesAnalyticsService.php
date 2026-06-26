<?php

namespace Src\Services\Analytics;

use Src\Core\Database;
use PDO;

class SalesAnalyticsService
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

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