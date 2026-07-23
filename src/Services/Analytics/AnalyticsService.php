<?php

namespace Src\Services\Analytics;

class AnalyticsService
{
    private InventoryAnalyticsService $inventory;
    private SalesAnalyticsService $sales;


    public function __construct(
        InventoryAnalyticsService $inventory,
        SalesAnalyticsService $sales
    ) {
        $this->inventory = $inventory;
        $this->sales = $sales;
    }


    /*
    |--------------------------------------------------------------------------
    | INVENTORY ANALYTICS
    |--------------------------------------------------------------------------
    */

    public function getInventoryOverview(): array
    {
        return $this->inventory->getInventoryOverview();
    }


    public function getLowStockProducts(): array
    {
        return $this->inventory->getLowStockProducts();
    }


    public function getHighStockProducts(): array
    {
        return $this->inventory->getHighStockProducts();
    }



    /*
    |--------------------------------------------------------------------------
    | SALES ANALYTICS
    |--------------------------------------------------------------------------
    */

    public function getSalesOverview(): array
    {
        return $this->sales->getSalesOverview();
    }


    public function getDailySales(): array
    {
        return $this->sales->getDailySales();
    }


    public function getTopProducts(): array
    {
        return $this->sales->getTopProducts();
    }
}