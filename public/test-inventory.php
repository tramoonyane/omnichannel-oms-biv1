<?php

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Models/Product.php';
require_once __DIR__ . '/../src/Controllers/InventoryController.php';

use Src\Controllers\InventoryController;

$controller = new InventoryController();

echo "<pre>";
print_r($controller->getInventory());
echo "</pre>";