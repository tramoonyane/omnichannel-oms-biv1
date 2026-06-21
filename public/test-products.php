<?php

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Models/Product.php';

use Src\Models\Product;

$product = new Product();

// TEST 1: fetch all products
echo "<pre>";
print_r($product->getAll());
echo "</pre>";