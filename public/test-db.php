<?php

require_once __DIR__ . '/../src/Core/Database.php';

use Src\Core\Database;

try {
    $db = new Database();
    $conn = $db->getConnection();

    echo "Database connected successfully 🚀";

} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}