<?php

namespace Src\Services\Analytics;

class AnalyticsService
{
    private InventoryAnalyticsService $inventory;
    private SalesAnalyticsService $sales;

    public function __construct()
    {
        $this->inventory = new InventoryAnalyticsService();
        $this->sales = new SalesAnalyticsService();
    }

    // Inventory
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

    // Sales
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