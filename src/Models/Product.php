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

    // 1. Get all products
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Get single product by ID
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: null;
    }

    // 3. Create product
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
}