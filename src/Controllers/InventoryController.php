<?php

namespace Src\Controllers;

use Src\Models\Product;

class InventoryController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getInventory()
    {
        return $this->productModel->getAll();
    }
}