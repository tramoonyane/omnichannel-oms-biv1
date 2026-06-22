<?php

namespace Src\Models;

use Src\Core\Database;
use PDO;

class Product
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Get all products
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single product by ID (USED BY ORDER SYSTEM)
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create product
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (sku, title, price, stock_qty, low_threshold)
            VALUES (:sku, :title, :price, :stock_qty, :low_threshold)
        ");

        return $stmt->execute([
            'sku' => $data['sku'],
            'title' => $data['title'],
            'price' => $data['price'],
            'stock_qty' => $data['stock_qty'],
            'low_threshold' => $data['low_threshold']
        ]);
    }

    // Reduce stock (USED BY ORDER SYSTEM)
    public function reduceStock($id, $qty): bool
    {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET stock_qty = stock_qty - ?
            WHERE id = ?
        ");

        return $stmt->execute([$qty, $id]);
    }
}