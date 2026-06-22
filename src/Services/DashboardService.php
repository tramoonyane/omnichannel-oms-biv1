<?php

namespace Src\Services;

use Src\Services\AnalyticsService;
use Src\Core\Auth;

class DashboardService
{
    private AnalyticsService $analytics;

    public function __construct()
    {
        $this->analytics = new AnalyticsService();
    }

    public function getSummary(): array
    {
        $role = Auth::userRole();

        $inventory = $this->analytics->getInventoryOverview();
        $lowStock = $this->analytics->getLowStockProducts();
        $sales = $this->analytics->getSalesOverview();
        $topProducts = $this->analytics->getTopProducts();

        $alerts = [];

        if (count($lowStock) > 0) {
            $alerts[] = [
                "type" => "LOW_STOCK",
                "message" => count($lowStock) . " products need restocking"
            ];
        }

        $response = [
            "role" => $role,
            "inventory" => $inventory,
            "alerts" => $alerts
        ];

        // ADMIN VIEW (FULL ACCESS)
        if ($role === "admin") {
            $response["sales"] = $sales;
            $response["top_products"] = $topProducts;
        }

        // MANAGER VIEW (LIMITED)
        if ($role === "manager") {
            $response["sales"] = $sales;
        }

        return $response;
    }
}