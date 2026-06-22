<?php

namespace Src\Controllers;

use Src\Services\AnalyticsService;

class AnalyticsController
{
    private AnalyticsService $service;

    public function __construct()
    {
        $this->service = new AnalyticsService();
    }

    public function inventoryOverview()
    {
        return $this->service->getInventoryOverview();
    }

    public function lowStock()
    {
        return $this->service->getLowStockProducts();
    }

    public function highStock()
    {
        return $this->service->getHighStockProducts();
    }

    public function getSalesOverview()
{
return $this->service->getSalesOverview();
}

public function getDailySales()
{
return $this->service->getDailySales();
}

public function getTopProducts()
{
return $this->service->getTopProducts();
}

}
