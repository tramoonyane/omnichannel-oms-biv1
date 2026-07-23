<?php

namespace Src\Controllers;

use Src\Models\Product;

class InventoryController
{
    private Product $productModel;


    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }


    public function getInventory()
    {
        return $this->productModel->getAll();
    }
}