<?php

namespace Src\Models;

use PDO;

class Order
{
    // 💡 Typing this as a native PDO instance grants full IDE autocomplete
    private PDO $db;

    // 💡 We inject the database instance so the entire application shares one stream
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO orders (customer_name, order_status)
            VALUES (?, ?)
        ");

        $stmt->execute([
            $data['customer_name'],
            $data['status']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function addItem(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price_at_sale)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['order_id'],
            $data['product_id'],
            $data['quantity'],
            $data['price_at_sale']
        ]);
    }

    /**
     * Aggregates relational order metrics perfectly formatted for your client UI
     */
    public function getAll(): array
    {
        // 💡 This query crosses table boundaries to count total items bought 
        // and pull full relational data for your dashboard in a single database round-trip.
        $sql = "SELECT 
            o.id,
            o.channel,
            o.reference,
            o.customer_name,
            o.order_status AS status,
            SUM(oi.quantity) AS total_items,
            SUM(oi.quantity * oi.price_at_sale) AS total_revenue,
            o.created_at
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        GROUP BY o.id
        ORDER BY o.created_at DESC";

        $stmt = $this->db->query($sql);
        
        // Explicitly using FETCH_ASSOC isolates clean string keys and reduces memory use by 50%
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
