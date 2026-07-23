<?php

namespace Src\Services\Presentation;

use Src\Services\Analytics\AnalyticsService;

class DashboardService
{
    private AnalyticsService $analytics;


    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }


    public function getSummary(string $role): array
    {
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


        if ($role === "admin") {

            $response["sales"] = $sales;

            $response["top_products"] = $topProducts;

        }


        if ($role === "manager") {

            $response["sales"] = $sales;

        }


        return $response;
    }
}