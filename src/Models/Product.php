<?php

namespace Src\Models;

use PDO;

class Product
{
    private PDO $db;

    // 💡 Inject the central PDO instance so this model shares the same connection pool
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Get all products
    public function getAll(): array
    {
        // 💡 We use SQL aliasing "title AS name" to fix the naming disconnect 
        // with your InventoryService without breaking your existing database schema!
        $stmt = $this->db->prepare("SELECT id, sku, title, title AS name, price, stock_qty, low_threshold FROM products");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single product by ID
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT id, sku, title, title AS name, price, stock_qty, low_threshold FROM products WHERE id = ?");
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
            'title' => $data['title'] ?? $data['name'], // Fallback safely to support both naming keys
            'price' => $data['price'],
            'stock_qty' => $data['stock_qty'],
            'low_threshold' => $data['low_threshold']
        ]);
    }

    // Reduce stock
    public function reduceStock($id, $qty): bool
    {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET stock_qty = stock_qty - ?
            WHERE id = ?
        ");

        return $stmt->execute([$qty, $id]);
    }

    /**
     * Highly optimized memory handling for business intelligence alerts
     * Fetches ONLY products that are low on inventory directly at the database layer.
     */
    public function getLowStock(): array
    {
        $sql = "SELECT id, sku, title, title AS name, stock_qty, low_threshold 
                FROM products 
                WHERE stock_qty <= low_threshold";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
