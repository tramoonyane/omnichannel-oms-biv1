<?php

namespace Src\Models;

use Src\Core\Database;

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO orders (customer_name, order_status)
            VALUES (?, ?)
        ");

        $stmt->execute([
            $data['customer_name'],
            $data['status']
        ]);

        return $this->db->lastInsertId();
    }

    public function addItem($data)
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

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM orders");
        return $stmt->fetchAll();
    }
}