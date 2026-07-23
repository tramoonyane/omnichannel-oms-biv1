<?php

namespace Src\Services\Presentation;

use Src\Services\Analytics\AnalyticsService;

class ChartService
{
    private AnalyticsService $analytics;


    public function __construct(
        AnalyticsService $analytics
    ) {
        $this->analytics = $analytics;
    }


    /**
     * SALES TREND CHART
     */
    public function salesTrend(): array
    {
        $data = $this->analytics->getDailySales();

        return [
            "chartType" => "line",

            "meta" => [
                "title" => "Daily Sales Trend",
                "description" => "Revenue and order trends over time"
            ],

            "xKey" => "date",

            "series" => [
                [
                    "dataKey" => "revenue",
                    "label" => "Revenue",
                    "valueFormat" => "raw"
                ],
                [
                    "dataKey" => "orders",
                    "label" => "Orders",
                    "valueFormat" => "integer"
                ]
            ],

            "data" => $data
        ];
    }



    /**
     * TOP PRODUCTS CHART
     */
    public function topProducts(): array
    {
        $data = $this->analytics->getTopProducts();

        return [
            "chartType" => "bar",

            "meta" => [
                "title" => "Top Selling Products",
                "description" => "Products ranked by revenue and units sold"
            ],

            "xKey" => "title",

            "series" => [
                [
                    "dataKey" => "total_sold",
                    "label" => "Units Sold",
                    "valueFormat" => "integer"
                ],
                [
                    "dataKey" => "revenue",
                    "label" => "Revenue",
                    "valueFormat" => "raw"
                ]
            ],

            "data" => $data
        ];
    }



    /**
     * INVENTORY DISTRIBUTION CHART
     */
    public function inventoryDistribution(): array
    {
        $data = $this->analytics->getLowStockProducts();

        return [
            "chartType" => "bar",

            "meta" => [
                "title" => "Low Stock Products",
                "description" => "Products that need restocking"
            ],

            "xKey" => "title",

            "series" => [
                [
                    "dataKey" => "stock_qty",
                    "label" => "Stock Level",
                    "valueFormat" => "integer"
                ]
            ],

            "data" => $data
        ];
    }
}