<?php

namespace Src\Controllers;

use Src\Services\Analytics\AnalyticsService;

class AnalyticsController
{
    private AnalyticsService $service;


    public function __construct(
        AnalyticsService $service
    ) {
        $this->service = $service;
    }



    /*
    |--------------------------------------------------------------------------
    | INVENTORY ANALYTICS
    |--------------------------------------------------------------------------
    */


    public function inventoryOverview(): array
    {
        return $this->service->getInventoryOverview();
    }


    public function lowStock(): array
    {
        return $this->service->getLowStockProducts();
    }


    public function highStock(): array
    {
        return $this->service->getHighStockProducts();
    }



    /*
    |--------------------------------------------------------------------------
    | SALES ANALYTICS
    |--------------------------------------------------------------------------
    */


    public function getSalesOverview(): array
    {
        return $this->service->getSalesOverview();
    }


    public function getDailySales(): array
    {
        return $this->service->getDailySales();
    }


    public function getTopProducts(): array
    {
        return $this->service->getTopProducts();
    }
}